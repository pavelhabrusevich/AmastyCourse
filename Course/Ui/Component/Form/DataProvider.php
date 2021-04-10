<?php

namespace Amasty\Course\Ui\Component\Form;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Amasty\Course\Model\ResourceModel\Blacklist\CollectionFactory;

class DataProvider extends AbstractDataProvider
{
    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @var CollectionFactory
     */
    protected $collectionFactory;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
    }

    public function getData()
    {
        if (!isset($this->loadedData)) {
            $blacklist = $this->collection->getItems();

            foreach ($blacklist as $item) {
                $this->loadedData[$item->getId()] = $item->getData();
            }
        }

        return $this->loadedData;
    }
}
