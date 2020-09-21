<?php

namespace UK\SeoTool\Block;

use Magento\Cms\Model\Page;
use Magento\Framework\Locale\Resolver as LocaleResolver;
use Magento\Framework\View\Element\Template;
use Magento\Framework\View\Element\Template\Context;

class SeoTool extends Template
{
    /**
     * @var Page
     */
    private $page;

    /**
     * @var LocaleResolver
     */
    private $localeResolver;

    /**
     * @param Page $page
     * @param LocaleResolver $localeResolver
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        Page $page,
        LocaleResolver $localeResolver,
        Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->page = $page;
        $this->localeResolver = $localeResolver;
    }

    /**
     * @return array
     */
    public function getHreflangs()
    {
        $hreflangs = [];
        if ($this->page->getId()) {
            $storeIds = $this->page->getStores();
            if (count($storeIds) > 1) {
                foreach ($storeIds as $storeId) {
                    $this->localeResolver->emulate($storeId);
                    $hreflangs[] = [
                        'locale' => mb_strtolower(str_replace('_', '-', $this->localeResolver->getLocale())),
                        'url' => $this->_storeManager->getStore($storeId)->getBaseUrl() . $this->page->getIdentifier()
                    ];
                    $this->localeResolver->revert();
                }
            }
        }

        return $hreflangs;
    }
}
