<?php

namespace Exam\Feature\Block;

class Feature extends \Magento\Framework\View\Element\Template
{
    /**
     * @var \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory
     */
    protected $_productCollectionFactory;

    /**
     * @var \Magento\Catalog\Helper\Image
     */
    protected $imageHelper;

    /**
     * @var \Magento\Framework\Pricing\PriceCurrencyInterface
     */
    protected $priceCurrency;

    /**
     * @var \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory
     */
    protected $categoryCollection;
    
    /**
     * @var \Magento\Catalog\Model\ResourceModel\CategoryFactory
     */
    protected $categoryResourceFactory;

    /**
     * @var \Magento\Catalog\Model\CategoryFactory
     */
    protected $categoryFactory;

    /**
     * @var \Magento\Catalog\Model\Category
     */
    protected $category;

    /**
     * @var \Magento\Store\Model\StoreManagerInterface
     */
    protected $_storeManager;

	public function __construct(
        \Magento\Framework\View\Element\Template\Context $context,
        \Magento\Catalog\Model\ResourceModel\Product\CollectionFactory $productCollectionFactory,
        \Magento\Catalog\Helper\Image $imageHelper,
        \Magento\Framework\Pricing\PriceCurrencyInterface $priceCurrency,
        \Magento\Catalog\Model\ResourceModel\Category\CollectionFactory $categoryCollection,
        \Magento\Catalog\Model\ResourceModel\CategoryFactory $categoryResourceFactory,
        \Magento\Catalog\Model\CategoryFactory $categoryFactory,
        \Magento\Catalog\Model\Category $category,
        \Magento\Store\Model\StoreManagerInterface $storeManager
    )
	{
        $this->_productCollectionFactory = $productCollectionFactory;
        $this->imageHelper = $imageHelper;
        $this->priceCurrency = $priceCurrency;
        $this->categoryCollection = $categoryCollection;
        $this->_storeManager = $storeManager;
        $this->categoryResourceFactory = $categoryResourceFactory;
        $this->categoryFactory = $categoryFactory;
        $this->category = $category;
		parent::__construct($context);
	}

    public function getFeaturedProductCollection() {
        $rootCategory = $this->_storeManager->getStore()->getRootCategoryId();
        $collection = $this->_productCollectionFactory->create();
        $collection->addAttributeToSelect('*');
        $collection->addCategoriesFilter(['in' => 4]);
        $collection->setPageSize(5);
        return $collection;
    }

    public function getProductImageUrl($product, $width, $height) {

        $imageUrl = $this->imageHelper->init($product, 'product_page_image_small')
                ->setImageFile($product->getImage()) // image,small_image,thumbnail
                ->resize($width, $height)
                ->getUrl();
        return $imageUrl;
    }
    public function getCurrencyFormat($price, $includeContainer = false, $precision = 2) {
        return $this->priceCurrency->format($price, $includeContainer = true, $precision = $precision, $scope = null, $currency = null);
    }

    public function getChildCategory(){
        $rootCategory = $this->_storeManager->getStore()->getRootCategoryId();
        return $this->categoryFactory->create()->load($rootCategory)->getChildrenCategories();
    }

    public function getCategory($categoryId){
        return $this->category->load($categoryId);
    }
}
