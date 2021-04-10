<?php

namespace Amasty\Course\Controller\Adminhtml\Blacklist;

use Magento\Backend\App\Action;
use Magento\Framework\View\Result\PageFactory;

class Index extends \Magento\Backend\App\Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    public function __construct(
        PageFactory $resultPageFactory,
        Action\Context $context
    ) {
        $this->resultPageFactory = $resultPageFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->getConfig()->getTitle()->prepend(__('Blacklist'));

        return $resultPage;
    }
}
