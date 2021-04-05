<?php

namespace Amasty\Course\Model\ResourceModel;
use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Blacklist extends AbstractDb
{
    protected function _construct()
    {
        $this->_init(
            'amasty_product_blacklist',
            'entity_id'
        );
    }
}
