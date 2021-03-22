<?php

namespace Amasty\Course\Controller\Index;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollectionFactory;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;

class Form extends Action
{
    /**
     * @var CheckoutSession
     */
    private $checkoutSession;

    /**
     * @var ProductCollectionFactory
     */
    private $productCollectionFactory;

    public function __construct(
        Context $context,
        CheckoutSession $checkoutSession,
        ProductCollectionFactory $productCollectionFactory
    ) {
        parent::__construct($context);
        $this->checkoutSession = $checkoutSession;
        $this->productCollectionFactory = $productCollectionFactory;
    }

    public function execute()
    {
        $formValue = $this->getRequest()->getPost();
        $sku = $formValue['sku'];
        $qty = $formValue['qty'];

        $quote = $this->checkoutSession->getQuote();
        if (!$quote->getId()) {
            $quote->save();
        }

        $productCollection = $this->productCollectionFactory->create();
        $productCollection->addAttributeToFilter('sku', [$sku]);
        $product = $productCollection->getFirstItem();

        // проверяем тип продукта
        if ($product->getData('type_id') == 'simple') {
            $quote->addProduct($product, $qty);
            $quote->save();
        } else {
            $this->messageManager->addWarningMessage('Only Simple Product');
        }

        //остальные проверки в процессе

        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        return $redirect->setUrl('/amcourse');
    }
}
