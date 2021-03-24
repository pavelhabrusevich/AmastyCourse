<?php

namespace Amasty\Course\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Amasty\Course\Model\ConfigProvider;

class Index extends Action
{
    /**
     * @var ConfigProvider
     */
    private $scopeConfig;

    public function __construct(
        Context $context,
        ConfigProvider $scopeConfig
    ) {
        $this->scopeConfig = $scopeConfig;
        parent::__construct($context);
    }

    public function execute()
    {
        if ($this->scopeConfig->isEnabledModule()) {
            return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        } else {
            $resultForward = $this->resultFactory->create(ResultFactory::TYPE_FORWARD);
            return $resultForward->forward('defaultNoRoute');
        }
    }
}
