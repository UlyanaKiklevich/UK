<?php

namespace UK\StoreColor\Block;

use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Module\Dir;
use Magento\Framework\Module\Dir\Reader;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class CustomStyles extends Template
{
    /**
     * @var string
     */
    private $filePath;

    /**
     * @var Reader
     */
    private $moduleReader;

    /**
     * @param Context $context
     * @param Reader $moduleReader
     * @param array $data
     */
    public function __construct(
        Context $context,
        Reader $moduleReader,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->moduleReader = $moduleReader;
    }

    /**
     * @return string
     */
    public function getCssFile()
    {
        if ($this->filePath === null) {
            $this->filePath = '';
            $storeId = $this->_storeManager->getStore()->getId();
            $fileName = 'custom_styles_' . $storeId . '.css';
            $directory = $this->moduleReader->getModuleDir(Dir::MODULE_VIEW_DIR, 'UK_StoreColor')
                . '/frontend/web/css/';
            if (file_exists($directory . $fileName)) {
                $this->filePath = $this->getViewFileUrl('UK_StoreColor::css/' . $fileName);
            } elseif (file_exists($directory . 'custom_styles_0.css')) {
                $this->filePath = $this->getViewFileUrl('UK_StoreColor::css/custom_styles_0.css');
            }
        }

        return $this->filePath;
    }
}
