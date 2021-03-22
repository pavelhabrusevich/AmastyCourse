<?php

namespace Amasty\Course\Block;

use Amasty\Course\Model\ConfigProvider;
use Magento\Framework\View\Element\Template;

class Form extends Template
{
    /**
     * @var ConfigProvider
     */
    private $configProvider;

    public function __construct(
        Template\Context $context,
        ConfigProvider $configProvider,
        array $data = []
    ) {
        $this->configProvider = $configProvider;
        parent::__construct($context, $data);
    }

    public function showQty(): bool
    {
        if ($this->configProvider->isEnabledShowQty()) {
            return true;
        } else {
            return false;
        }
    }

    public function qty()
    {
        $qty = $this->configProvider->getQty();
        if ($qty) {
            return $qty;
        } else {
            return '';
        }
    }

    public function getUrlAction()
    {
        return $this->getUrl('amcourse/index/form', ['_secure' => true]);
    }
}
