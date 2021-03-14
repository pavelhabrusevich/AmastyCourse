<?php

namespace Amasty\Course\Controller\Index;

use Magento\Framework\App\Action\Action;
use Magento\Framework\Controller\ResultFactory;

class Index extends Action
{
    public function execute()
    {
        die('Привет Magento. Привет Amasty. Я готов тебя покорить!');
//        return $this->resultFactory->create(ResultFactory::TYPE_PAGE);
    }
}
