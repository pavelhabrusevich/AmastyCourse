<?php

namespace Amasty\Course\Model;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory as ProductCollection;
use Magento\Framework\App\RequestInterface;

class SearchProduct
{
    /**
     * @var ProductCollection
     */
    private $productCollection;

    /**
     * @var RequestInterface
     */
    private $request;

    public function __construct(
        ProductCollection $productCollection,
        RequestInterface $request
    ) {
        $this->productCollection = $productCollection;
        $this->request = $request;
    }

    public function getSearchResult()
    {
        $searchRequest = $this->request->getParam('sku');

        $productCollection = $this->productCollection->create();
        $productCollection->addAttributeToFilter('sku', ['like' => "%{$searchRequest}%"]);
        $productCollection->addAttributeToSelect('*');
        $productCollection->setPageSize(10); //думаю, правильнее вынести PageSize в конфиг модуля

        $products = [];

        foreach ($productCollection as $product) {
            $productSku = $product->getDataByKey('sku');
            $productName = $product->getName();
            $products[] = [
                'sku' => $productSku,
                'name' => $productName
            ];
        }

        return $products;
    }
}
