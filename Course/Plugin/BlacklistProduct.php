<?php

namespace Amasty\Course\Plugin;

use Amasty\Course\Api\BlacklistRepositoryInterface;
use Amasty\Course\Model\ResourceModel\Blacklist as BlacklistResource;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Message\ManagerInterface;

class BlacklistProduct
{
    /**
     * @var BlacklistResource
     */
    protected $blacklistResource;

    /**
     * @var RequestInterface
     */
    private $request;

    /**
     * @var CheckoutSession
     */
    private $checkoutSession;

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var ManagerInterface
     */
    private $messageManager;

    /**
     * @var ResultFactory
     */
    private $resultFactory;

    /**
     * @var BlacklistRepositoryInterface
     */
    private $blacklistRepositoryInterface;

    public function __construct(
        BlacklistResource $blacklistResource,
        RequestInterface $request,
        CheckoutSession $checkoutSession,
        ProductRepositoryInterface $productRepository,
        ManagerInterface $messageManager,
        ResultFactory $resultFactory,
        BlacklistRepositoryInterface $blacklistRepositoryInterface
    ) {
        $this->blacklistResource = $blacklistResource;
        $this->request = $request;
        $this->checkoutSession = $checkoutSession;
        $this->productRepository = $productRepository;
        $this->messageManager = $messageManager;
        $this->resultFactory = $resultFactory;
        $this->blacklistRepositoryInterface = $blacklistRepositoryInterface;
    }

    public function aroundExecute(\Amasty\Course\Controller\Index\Form $subject, callable $proceed)
    {
        $addedProduct = $this->request->getParam('sku');

        $blacklist = $this->blacklistRepositoryInterface->getBySku($addedProduct);

        if ($addedProduct !== $blacklist->getProductSku()) {
            return $proceed();
        } else {
            $itemQtyInCart = [];
            foreach ($this->checkoutSession->getQuote()->getItemsCollection() as $item) {
                $cartTotal[] = $addedProduct === $item->getData('sku') ? $item->getData('qty') : 0;
            }
            $addedProductQty = $this->request->getParam('qty');
            $requestProductQty = $addedProductQty + array_sum($itemQtyInCart);

            $blacklistProductQty = $blacklist->getProductQty();
            if ($blacklistProductQty >= $requestProductQty) {
                $this->addToCart($addedProduct, $addedProductQty);
                $this->blacklistRepositoryInterface->setProductQty($addedProduct, $blacklistProductQty - $requestProductQty);
                $this->messageManager->addSuccessMessage($requestProductQty . ' product(s) is decreased in Blacklist');
            } elseif ($blacklistProductQty == 0) {
                $this->messageManager->addErrorMessage('Product is not added. No product in Blacklist');
            } else {
                $this->addToCart($addedProduct, $blacklistProductQty);
                $this->blacklistRepositoryInterface->setProductQty($addedProduct, 0);
                $this->messageManager->addWarningMessage($blacklistProductQty . ' product(s) is decreased in Blacklist only');
            }

            return $this->resultFactory->create(ResultFactory::TYPE_REDIRECT)->setUrl('/amcourse');
        }
    }

    public function addToCart($addedProduct, $addedProductQty)
    {
        $quote = $this->checkoutSession->getQuote();
        $product = $this->productRepository->get($addedProduct);
        $quote->addProduct($product, $addedProductQty);
        $quote->collectTotals();
        $quote->save();
    }
}
