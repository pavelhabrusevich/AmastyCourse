<?php

namespace Amasty\AdditionalModule\Observer;

use Amasty\AdditionalModule\Model\ConfigProvider;
use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Framework\Message\ManagerInterface;

class AddPromoSku implements ObserverInterface
{
    /**
     * @var ConfigProvider
     */
    private $configProvider;

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

    public function __construct(
        ConfigProvider $configProvider,
        CheckoutSession $checkoutSession,
        ProductRepositoryInterface $productRepository,
        ManagerInterface $messageManager
    ) {
        $this->configProvider = $configProvider;
        $this->checkoutSession = $checkoutSession;
        $this->productRepository = $productRepository;
        $this->messageManager = $messageManager;
    }

    public function execute(Observer $observer)
    {
        $isEnabledModule = $this->configProvider->isEnabledModule();
        $promoSku = $this->configProvider->getPromoSku() ?? '';
        $forSku = $this->configProvider->getForSku();

        try {
            $promoProduct = $this->productRepository->get($promoSku);
        } catch (\Magento\Framework\Exception\NoSuchEntityException $e) {
            $promoProduct = false;
        }

        if ($isEnabledModule && $promoProduct) {
            $addedProduct = $observer->getData('added_promo_product');
            foreach ($forSku as $sku) {
                if ($sku === $addedProduct) {
                    $quote = $this->checkoutSession->getQuote();
                    $quote->addProduct($promoProduct, 1);
                    $quote->save();
                    $this->messageManager->addSuccessMessage('Promo product is added');
                }
            }
        }
    }
}
