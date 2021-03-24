<?php

namespace Amasty\Course\Block;

use Magento\Framework\View\Element\Template;
use Amasty\Course\Model\ConfigProvider;

class Hello extends Template
{
    /**
     * @var ConfigProvider
     */
    private $scopeConfig;

    public function __construct(
        Template\Context $context,
        ConfigProvider $scopeConfig,
        array $data = []
    ) {
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context, $data);
    }

    public function greetingFromConfig(): string
    {
        return $this->scopeConfig->getGreeting();
    }
}
