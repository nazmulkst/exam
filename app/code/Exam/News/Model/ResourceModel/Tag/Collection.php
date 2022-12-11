<?php

namespace Exam\News\Model\ResourceModel\Tag;

use Exam\News\Model\ResourceModel\AbstractCollection;

class Collection extends AbstractCollection
{
    protected $_idFieldName = 'tag_id';
    protected $_eventPrefix = 'news_blog_tag_collection';
    protected $_eventObject = 'news_blog_tag_collection';

    /**
     * Define resource model
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Exam\News\Model\Tag', 'Exam\News\Model\ResourceModel\Tag');
    }

    /**
     * Join Left news_blog_tag_post table
     */
    public function joinPostTable()
    {
        $this->addFilterToMap('tag_id', 'main_table.tag_id');
        $this->getSelect()->joinLeft(
            ['post_tag' => $this->getTable('news_blog_tag_post')],
            'main_table.tag_id = post_tag.tag_id',
            'post_id'
        );
    }
}
