<?php

namespace Exam\News\Controller\Adminhtml\Author;

use Exam\News\Controller\Adminhtml\AbstractAuthor;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;

class Index extends AbstractAuthor
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Exam_News::author';

    /**
     * @return ResultInterface|ResponseInterface
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Exam_News::news_blog');
        $resultPage->getConfig()->getTitle()->prepend(__('Author List'));
        return $resultPage;
    }
}
