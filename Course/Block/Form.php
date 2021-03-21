<?php

namespace Amasty\Course\Block;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\View\Element\Template;

class Form extends Template
{
    /**
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    public function __construct(
        Template\Context $context,
        ScopeConfigInterface $scopeConfig,
        array $data = []
    ) {
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context, $data);
    }

    public function showQty(): bool
    {
        if ($this->scopeConfig->isSetFlag('am_course_config/general/show_qty')) {
            return true;
        } else {
            return false;
        }
    }

    public function qty()
    {
        if ($qty = $this->scopeConfig->getValue('am_course_config/general/qty')) {
            return $qty;
        } else {
            return '';
        }
    }
}
