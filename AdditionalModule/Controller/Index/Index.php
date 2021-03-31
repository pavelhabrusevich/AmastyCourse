<?php

namespace Amasty\AdditionalModule\Controller\Index;

use Amasty\Course\Model\ConfigProvider;
use Magento\Customer\Model\Session;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;

class Index extends Action
{
    /**
     * @var ConfigProvider
     */
    private $scopeConfig;

    /**
     * @var Session
     */
    private $customerSession;

    public function __construct(
        ConfigProvider $scopeConfig,
        Session $customerSession,
        Context $context
    ) {
        $this->scopeConfig = $scopeConfig;
        $this->customerSession = $customerSession;
        parent::__construct($context);
    }

    public function execute()
    {
        if ($this->scopeConfig->isEnabledModule() && $this->customerSession->isLoggedIn()) {
            return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
        } else {
            $resultForward = $this->resultFactory->create(ResultFactory::TYPE_FORWARD);
            return $resultForward->forward('defaultNoRoute');
        }
    }
}
