<?php

namespace Amasty\Course\Api;

interface BlacklistRepositoryInterface
{
    public function getBySku($productSku);

    public function setProductQty($productSku, $qty);
}
