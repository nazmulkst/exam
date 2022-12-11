<?php

namespace Exam\News\Controller\Adminhtml\Category;

use Exam\News\Controller\Adminhtml\AbstractCategory;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;

class Index extends AbstractCategory
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Exam_News::category';

    /**
     * @return ResultInterface|ResponseInterface
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Exam_News::news_blog');
        $resultPage->getConfig()->getTitle()->prepend(__('Category List'));
        return $resultPage;
    }
}
