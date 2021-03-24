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
        if ($this->getRequest()->getPost()) {
            $sku = $this->getRequest()->getPost()['sku'];
            $qty = $this->getRequest()->getPost()['qty'];

            $quote = $this->checkoutSession->getQuote(); // реализовать через ресурсную модель, когда разберем

            // на лекции мы сохраняли квоту на случай, если ее не будет. https://youtu.be/DlRsOUiacrE?list=PLjdyzbzyb4VQSKEGfRgWfXIxJetQ1_IEj&t=3298
//        if (!$quote->getId()) {
//            $quote->save();
//        }

            $productCollection = $this->productCollectionFactory->create();
            $productCollection->addAttributeToFilter('sku', [$sku]);
            $product = $productCollection->getFirstItem();

            // проверяем тип продукта
            if ($product->getTypeId() === \Magento\Catalog\Model\Product\Type::TYPE_SIMPLE) {
                $quote->addProduct($product, $qty);
                $quote->save();
                $this->messageManager->addSuccessMessage('Product is Added');
            } else {
                $this->messageManager->addWarningMessage('Only Simple Product');
            }

            //остальные проверки в процессе

            $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
            return $redirect->setUrl('/amcourse');
        }
    }
}
