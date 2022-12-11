<?php

namespace Exam\News\Controller\Adminhtml\Tag;

use Exam\News\Controller\Adminhtml\AbstractTag;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\ResultInterface;

class Delete extends AbstractTag
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    const ADMIN_RESOURCE = 'Exam_News::tag_delete';

    /**
     * @return ResultInterface|ResponseInterface
     * @throws \Exception
     */
    public function execute()
    {
        $deleteId = (int)$this->getRequest()->getParam('tag_id');
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($deleteId) {
            $tagModel = $this->tagFactory->create();
            try {
                $tagModel->load($deleteId);
                $tagModel->delete();
                $this->messageManager->addSuccessMessage(__('The tag has been deleted successfully'));
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage(__('Something went wrong while deleting the tag.'));
                $this->logger->critical($e->getMessage());
            }
        }
        return $resultRedirect->setPath('*/*/');
    }
}
