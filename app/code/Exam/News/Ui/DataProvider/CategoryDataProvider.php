<?php

namespace Exam\News\Ui\DataProvider;

use Exam\News\Model\ResourceModel\Category\Collection;
use Exam\News\Model\ResourceModel\Category\CollectionFactory;
use Magento\Framework\App\Request\DataPersistorInterface;
use Magento\Framework\Registry;
use Magento\Ui\DataProvider\AbstractDataProvider;

class CategoryDataProvider extends AbstractDataProvider
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $primaryFieldName;

    /**
     * @var string
     */
    protected $requestFieldName;


    /**
     * @var Collection
     */
    protected $collection;

    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @var DataPersistorInterface
     */
    protected $dataPersistor;

    /**
     * @var Registry
     */
    protected $coreRegistry;

    /**
     * CategoryDataProvider constructor.
     * @param string $name
     * @param string $primaryFieldName
     * @param string $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param DataPersistorInterface $dataPersistor
     * @param Registry $coreRegistry
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        DataPersistorInterface $dataPersistor,
        Registry $coreRegistry,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
        $this->dataPersistor = $dataPersistor;
        $this->coreRegistry = $coreRegistry;
    }

    /**
     * @return array
     */
    public function getData()
    {
        if (isset($this->loadedData)) {
            return $this->loadedData;
        }

        $currentCategory = $this->coreRegistry->registry('current_category');
        if ($currentCategory->getId()) {
            $this->loadedData[$currentCategory->getId()] = $currentCategory->getData();
        } else {
            $this->loadedData = [];
        }
        $data = $this->dataPersistor->get('blog_category');
        if (!empty($data)) {
            $category = $this->collection->getNewEmptyItem();
            $category->setData($data);
            $this->loadedData[$category->getId()] = $category->getData();
            $this->dataPersistor->clear('blog_category');
        }

        return $this->loadedData;
    }
}
