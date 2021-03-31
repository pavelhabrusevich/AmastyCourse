<?php

namespace Amasty\Course\Block;

use Amasty\AdditionalModule\Model\ConfigProvider as AdditionalConfig;
use Amasty\Course\Model\ConfigProvider;
use Magento\Framework\View\Element\Template;

class Form extends Template
{
    const FORM_ACTION = 'amcourse/index/form';

    /**
     * @var ConfigProvider
     */
    private $configProvider;

    /**
     * @var AdditionalConfig
     */
    private $additionalConfig;

    public function __construct(
        Template\Context $context,
        ConfigProvider $configProvider,
        AdditionalConfig $additionalConfig,
        array $data = []
    ) {
        $this->configProvider = $configProvider;
        $this->additionalConfig = $additionalConfig;
        parent::__construct($context, $data);
    }

    public function showQty(): bool
    {
        return $this->configProvider->isEnabledShowQty();
    }

    public function getQty(): string
    {
        return $this->configProvider->getQty() ?? '';
    }

    public function getUrlAction()
    {
        if ($this->additionalConfig->isEnabledMagAddProduct()) {
            return $this->getUrl($this->getFormAction(), ['_secure' => true]); //use \Magento\Checkout\Controller\Cart\Add
        }
        return $this->getUrl(self::FORM_ACTION, ['_secure' => true]); //use \Amasty\Course\Controller\Index\Form
    }

    public function getFormAction()
    {
        return self::FORM_ACTION;
    }
}
