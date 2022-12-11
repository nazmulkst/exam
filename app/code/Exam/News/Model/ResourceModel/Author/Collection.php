<?php

namespace Exam\News\Model\ResourceModel\Author;

use Exam\News\Model\ResourceModel\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'author_id';
    protected $_eventPrefix = 'news_blog_author_collection';
    protected $_eventObject = 'news_blog_author_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Exam\News\Model\Author', 'Exam\News\Model\ResourceModel\Author');
    }
}
