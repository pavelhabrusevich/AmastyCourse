<?php

namespace Amasty\Course\Controller\Index;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product\Type;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\NoSuchEntityException;

class Form extends Action
{
    /**
     * @var CheckoutSession
     */
    private $checkoutSession;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    public function __construct(
        Context $context,
        CheckoutSession $checkoutSession,
        ProductRepositoryInterface $productRepository
    ) {
        parent::__construct($context);
        $this->checkoutSession = $checkoutSession;
        $this->productRepository = $productRepository;
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

            $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

            try {
                $product = $this->productRepository->get($sku);
                if ($product->getTypeId() !== Type::TYPE_SIMPLE) {
                    $this->messageManager->addWarningMessage('Only simple product is available');

                    return $redirect->setUrl('/amcourse');
                }
                $salableQty = $product->getQuantityAndStockStatus();
                if ($salableQty['qty'] >= $qty) {
                    $quote->addProduct($product, $qty);
                    $quote->save();
                    $this->messageManager->addSuccessMessage('Product is added');
                } else {
                    $this->messageManager->addErrorMessage('Product quantity is not available');
                }
            } catch (NoSuchEntityException $exception) {
                $this->messageManager->addErrorMessage('Product does not exist');
            }

            return $redirect->setUrl('/amcourse');
        }
    }
}
