<?php

namespace Amasty\Course\Controller\Index;

use Amasty\Course\Model\SearchProduct;
use Magento\Framework\App\Action\Action;
use Magento\Framework\App\Action\Context;
use Magento\Framework\Controller\ResultFactory;

class Search extends Action
{
    /**
     * @var SearchProduct
     */
    private $searchResult;

    public function __construct(
        SearchProduct $searchResult,
        Context $context
    ) {
        $this->searchResult = $searchResult;
        parent::__construct($context);
    }

    public function execute()
    {
        $products = $this->searchResult->getSearchResult();
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $resultJson->setData($products);

        return $resultJson;
    }
}
