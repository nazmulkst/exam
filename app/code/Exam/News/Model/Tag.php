<?php

namespace Exam\News\Model;

use Exam\News\Api\Data\TagInterface;
use Exam\News\Model\Config\Config;
use Magento\Framework\Data\Collection\AbstractDb;
use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\Context;
use Magento\Framework\Model\ResourceModel\AbstractResource;
use Magento\Framework\Registry;

class Tag extends AbstractModel implements IdentityInterface, TagInterface
{
    const CACHE_TAG = 'news_blog_tag';

    protected $_cacheTag = 'news_blog_tag';

    protected $_eventObject = 'news_blog_tag';

    protected $_eventPrefix = 'news_blog_tag';

    protected $config;

    public function __construct(
        Context $context,
        Registry $registry,
        Config $config,
        AbstractResource $resource = null,
        AbstractDb $resourceCollection = null,
        array $data = []
    ) {
        $this->config = $config;
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    protected function _construct()
    {
        $this->_init('Exam\News\Model\ResourceModel\Tag');
    }

    /**
     * Get ID
     *
     * @return int|null
     */
    public function getId()
    {
        return $this->getData(self::TAG_ID);
    }

    /**
     * Return unique ID(s) for each object in system
     *
     * @return string[]
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * Get Name
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->getData(self::NAME);
    }

    /**
     * Get URL Key
     *
     * @return string|null
     */
    public function getUrlKey()
    {
        return $this->getData(self::URL_KEY);
    }

    /**
     * Set Name
     *
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        return $this->setData(self::NAME, $name);
    }

    /**
     * Set URL Key
     *
     * @param string $url
     * @return $this
     */
    public function setUrlKey($url)
    {
        return $this->setData(self::URL_KEY, $url);
    }

    /**
     * @param $url_key
     * @return mixed
     * @throws LocalizedException
     */
    public function checkUrlKey($url_key)
    {
        return $this->_getResource()->checkUrlKey($url_key);
    }

    public function getTagtUrl()
    {
        $prefixUrl = $this->config->getRouter();
        $urlKey = trim($this->getUrlKey());
        $postUrl = (!empty($prefixUrl)) ? '/' . $prefixUrl . '/tag/' . $urlKey : '/news_blog' . '/tag/' . $urlKey;
        return $postUrl;
    }
}
