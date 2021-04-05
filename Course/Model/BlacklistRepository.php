<?php

namespace Amasty\Course\Model;

use Amasty\Course\Api\BlacklistRepositoryInterface;
use Amasty\Course\Model\BlacklistFactory;
use Amasty\Course\Model\ResourceModel\Blacklist as BlacklistResource;

class BlacklistRepository implements BlacklistRepositoryInterface
{
    /**
     * @var BlacklistFactory
     */
    protected $blacklistFactory;

    /**
     * @var BlacklistResource
     */
    private $blacklistResource;

    public function __construct(
        BlacklistFactory $blacklistFactory,
        BlacklistResource $blacklistResource
    ) {
        $this->blacklistFactory = $blacklistFactory;
        $this->blacklistResource = $blacklistResource;
    }

    public function getBySku($productSku): Blacklist
    {
        $blacklist = $this->blacklistFactory->create();
        $this->blacklistResource->load(
            $blacklist,
            $productSku,
            'product_sku'
        );

        return $blacklist;
    }

    public function setProductQty($productSku, $qty)
    {
        $blacklist = $this->blacklistFactory->create();
        $this->blacklistResource->load(
            $blacklist,
            $productSku,
            'product_sku'
        );
        $blacklist->setProductQty($qty);
        $this->blacklistResource->save($blacklist);
    }
}
