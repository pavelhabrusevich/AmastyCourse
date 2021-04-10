<?php

namespace Amasty\Course\Controller\Adminhtml\Blacklist;

class Create extends \Magento\Backend\App\Action
{
    public function execute()
    {
        $this->_forward('edit');
    }
}
