<?php

namespace Amasty\Course\Controller\Index;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Catalog\Model\Product\Type;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Event\ManagerInterface as EventManager;
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

    /**
     * @var EventManager
     */
    private $eventManager;

    public function __construct(
        Context $context,
        CheckoutSession $checkoutSession,
        ProductRepositoryInterface $productRepository,
        EventManager $eventManager
    ) {
        parent::__construct($context);
        $this->checkoutSession = $checkoutSession;
        $this->productRepository = $productRepository;
        $this->eventManager = $eventManager;
    }

    public function execute()
    {
        $addedProductSku = $this->getRequest()->getParam('sku');
        $addedProductQty = $this->getRequest()->getPost()['qty'];

        $this->eventManager->dispatch(
            'amasty_add_promo_product_to_cart',
            ['added_promo_product' => $addedProductSku]
        );

        $redirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        if (isset($addedProductQty) && $addedProductQty > 0) {

            $quote = $this->checkoutSession->getQuote(); // реализовать через ресурсную модель, когда разберем


            try {
                $product = $this->productRepository->get($addedProductSku);
                if ($product->getTypeId() !== Type::TYPE_SIMPLE) {
                    $this->messageManager->addWarningMessage('Only simple product is available');

                    return $redirect->setUrl('/amcourse');
                }
                $salableQty = $product->getQuantityAndStockStatus();
                if ($salableQty['qty'] >= $addedProductQty) {
                    $quote->addProduct($product, $addedProductQty);
                    $quote->save();
                    $this->messageManager->addSuccessMessage('Product is added');
                } else {
                    $this->messageManager->addErrorMessage('Product quantity is not available');
                }
            } catch (NoSuchEntityException $exception) {
                $this->messageManager->addErrorMessage('Product does not exist');
            }

            return $redirect->setUrl('/amcourse');
        } else {
            $this->messageManager->addErrorMessage('Enable product quantity field in module configuration');
            return $redirect->setUrl('/amcourse');
        }
    }
}
