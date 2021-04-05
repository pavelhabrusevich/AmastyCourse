<?php

namespace Amasty\Course\Model;
use Magento\Framework\Model\AbstractModel;

/**
 * Class Blacklist
 * @method string getProductSku()
 * @method int getProductQty()
 */
class Blacklist extends AbstractModel
{
    protected function _construct()
    {
        $this->_init(
            ResourceModel\Blacklist::class
        );
    }
}
