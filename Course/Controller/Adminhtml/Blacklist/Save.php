<?php

namespace Amasty\Course\Controller\Adminhtml\Blacklist;

use Amasty\Course\Model\ResourceModel\Blacklist as BlacklistResource;
use Magento\Backend\App\Action;
use Amasty\Course\Model\BlacklistFactory;
use Magento\Setup\Exception;

class Save extends \Magento\Backend\App\Action
{
    /**
     * @var BlacklistResource
     */
    private $blacklistResource;

    /**
     * @var BlacklistFactory
     */
    private $blacklistFactory;

    public function __construct(
        BlacklistResource $blacklistResource,
        BlacklistFactory $blacklistFactory,
        Action\Context $context
    ) {
        $this->blacklistResource = $blacklistResource;
        $this->blacklistFactory = $blacklistFactory;
        parent::__construct($context);
    }

    public function execute()
    {
        if ($data = $this->getRequest()->getParams()) {
            $blacklistId = $this->getRequest()->getParam('entity_id');

            try {
                $blacklist = $this->blacklistFactory->create();

                if ($blacklistId) {
                    $this->blacklistResource->load($blacklist, $blacklistId);
                }

                $blacklist->addData($data);
                $this->blacklistResource->save($blacklist);
                $this->messageManager->addSuccessMessage('Saved');
            } catch (Exception $exception) {
                $this->messageManager->addExceptionMessage($exception, $exception->getMessage());
            }
        }

        return $this->_redirect('*/*/index');
    }
}
