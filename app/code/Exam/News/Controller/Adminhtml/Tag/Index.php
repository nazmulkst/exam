<?php

namespace Exam\News\Controller\Adminhtml\Tag;

use Exam\News\Controller\Adminhtml\AbstractTag;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;

class Index extends AbstractTag
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Exam_News::tag';

    /**
     * @return ResultInterface|ResponseInterface
     */
    public function execute()
    {
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Exam_News::Exam_News');
        $resultPage->getConfig()->getTitle()->prepend(__('Tag List'));
        return $resultPage;
    }
}
