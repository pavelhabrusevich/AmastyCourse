<?php

namespace Amasty\Course\Plugin;

use Magento\Framework\App\RequestInterface;
use Magento\Framework\Message\ManagerInterface;

class CheckRequestType
{
    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var ManagerInterface
     */
    private $messageManager;

    public function __construct(
        RequestInterface $request,
        ManagerInterface $messageManager
    ) {
        $this->request = $request;
        $this->messageManager = $messageManager;
    }

    public function aroundExecute($subject, callable $proceed, $observer)
    {
        if (!$this->request->isAjax()) {
            return $proceed($observer);
        } else {
            $this->messageManager->addWarningMessage('Promo product is not added');
        }
    }
}
