<?php

namespace Amasty\AdditionalModule\Plugin;

use Magento\Catalog\Api\ProductRepositoryInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Event\ManagerInterface as EventManager;
use Amasty\AdditionalModule\Model\ConfigProvider;
use Magento\Framework\Message\ManagerInterface;

class ChangeProductType
{
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;

    /**
     * @var RequestInterface
     */
    private $request;
    /**
     * @var EventManager
     */
    private $eventManager;

    /**
     * @var ConfigProvider
     */
    private $config;

    /**
     * @var ManagerInterface
     */
    private $messageManager;

    public function __construct(
        ProductRepositoryInterface $productRepository,
        RequestInterface $request,
        EventManager $eventManager,
        ConfigProvider $configProvider,
        ManagerInterface $messageManager
    ) {
        $this->productRepository = $productRepository;
        $this->request = $request;
        $this->eventManager = $eventManager;
        $this->config = $configProvider;
        $this->messageManager = $messageManager;
    }

    public function beforeExecute($subject)
    {
        if ($this->config->isEnabledMagAddProduct() && $this->request->getParam('qty')) {
            $productSku = $this->request->getParam('sku');

            $this->eventManager->dispatch(
                'amasty_add_promo_product_to_cart',
                ['added_promo_product' => $productSku]
            );

            $product = $this->productRepository->get($productSku);
            $productId = $product->getId();

            $this->request->setParam('product', $productId);
        } else {
            $this->messageManager->addErrorMessage('Enable product quantity field in module configuration');
        }
    }
}
