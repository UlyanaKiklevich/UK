<?php
namespace UK\StoreColor\Console\Command;

use Magento\Framework\Console\Cli;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Module\Dir;
use Magento\Framework\Module\Dir\Reader;
use Magento\Store\Model\StoreManagerInterface;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class StoreListCommand
 *
 * Command for listing the configured stores
 */
class StoreColor extends Command
{
    const TEMPLATE = 'custom_styles.css.sample';
    const OPTIONS = [
        'color' => ['mode' => InputOption::VALUE_REQUIRED, 'description' => 'New store color'],
        'store' => ['mode' => InputOption::VALUE_REQUIRED, 'description' => 'Store']
    ];

    /**
     * @var StoreManagerInterface
     */
    private $storeManager;

    /**
     * @var Reader
     */
    private $moduleReader;

    /**
     * @param StoreManagerInterface $storeManager
     * @param Reader $moduleReader
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        Reader $moduleReader
    ) {
        $this->storeManager = $storeManager;
        parent::__construct();
        $this->moduleReader = $moduleReader;
    }

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName('store:color')
            ->setDescription('Changes site color');
        foreach (self::OPTIONS as $value => $option) {
            $this->addOption(
                $value,
                null,
                $option['mode'],
                $option['description']
            );
        }

        parent::configure();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            foreach (self::OPTIONS as $option => $info) {
                $value = $input->getOption($option);
                if ($info['mode'] == InputOption::VALUE_REQUIRED && $value === null) {
                    throw new LocalizedException(__('Option %1 is missing', $option));
                }

                $output->writeln('<info>Provided ' . $option . ' is `' . $value . '`</info>');
                switch ($option) {
                    case 'color':
                        $this->validateColor($value);
                        break;
                    case 'store':
                        $this->validateStore($value);
                }
            }

            $this->apply($input->getOptions());
        } catch (\Exception $e) {
            $output->writeln('<error>' . $e->getMessage() . '</error>');
            if ($output->getVerbosity() >= OutputInterface::VERBOSITY_VERBOSE) {
                $output->writeln($e->getTraceAsString());
            }

            return Cli::RETURN_FAILURE;
        }

        $output->writeln('<info>New color was successfully applied!</info>');
        return Cli::RETURN_SUCCESS;
    }

    /**
     * @param string $color
     * @throws LocalizedException
     */
    protected function validateColor ($color)
    {
        $colorPattern = '/^([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/i';
        if (!preg_match($colorPattern, $color)) {
            throw new LocalizedException(__('An error encountered: COLOR has wrong format. Valid examples: 000 or dbdbdb.'));
        }
    }

    /**
     * @param string $storeId
     * @throws LocalizedException
     */
    protected function validateStore($storeId)
    {
        $storeExists = false;
        foreach ($this->storeManager->getStores(true) as $store) {
            if ($store->getId() === $storeId) {
                $storeExists = true;
                break;
            }
        }

        if (!$storeExists) {
            throw new LocalizedException(__('An error encountered: no store with ID %1 ', $storeId));
        }
    }

    /**
     * @param string[] $options
     */
    protected function apply(array $options)
    {
        $lessPath = $this->moduleReader->getModuleDir(Dir::MODULE_VIEW_DIR, 'UK_StoreColor')
            . '/frontend/web/css/';
        $template = file_get_contents($lessPath . self::TEMPLATE);
        $lessFilePath = $lessPath . 'custom_styles_' . $options['store'] . '.css';
        file_put_contents(
            $lessFilePath,
            str_replace('<%color%>', '#' . $options['color'], $template)
        );
    }
}
