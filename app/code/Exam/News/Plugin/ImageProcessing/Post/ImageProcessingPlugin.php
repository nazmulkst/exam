<?php

namespace Exam\News\Plugin\ImageProcessing\Post;

use Exam\News\Model\Post\File;
use Exam\News\Model\ImageUploader;
use Exam\News\Model\ResourceModel\Post as PostResource;
use Exam\News\Model\ResourceModel\Post\RedundantPostImageChecker;
use Exam\News\Plugin\ImageProcessing\AbstractImageProcessingPlugin;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;
use Psr\Log\LoggerInterface;

class ImageProcessingPlugin extends AbstractImageProcessingPlugin
{
    /**
     * @var RedundantPostImageChecker
     */
    private $redundantPostImageChecker;

    /**
     * @var File
     */
    private $file;

    /**
     * ImageProcessingPlugin constructor.
     * @param File $file
     * @param ImageUploader $imageUploader
     * @param LoggerInterface $logger
     * @param RedundantPostImageChecker $redundantPostImageChecker
     */
    public function __construct(
        File $file,
        ImageUploader $imageUploader,
        LoggerInterface $logger,
        RedundantPostImageChecker $redundantPostImageChecker
    ) {
        parent::__construct($imageUploader, $logger);
        $this->file = $file;
        $this->redundantPostImageChecker = $redundantPostImageChecker;
    }

    /**
     * @param PostResource $subject
     * @param AbstractModel $post
     */
    public function beforeSave(PostResource $subject, AbstractModel $post)
    {
        $value = $post->getData('image');
        if ($imageName = $this->getUploadedImageName($value)) {
            $post->setData('image', $value[0]['name']);
            $post->setData('image_obj', $value);
        } elseif (!is_string($value)) {
            $post->setData('image', null);
        }
    }

    /**
     * @param PostResource $subject
     * @param $result
     * @param AbstractModel $post
     * @return PostResource
     */
    public function afterSave(PostResource $subject, $result, AbstractModel $post): PostResource
    {
        $value = $post->getData('image_obj');
        if ($this->isTmpFileAvailable($value) && $imageName = $this->getUploadedImageName($value)) {
            try {
                $this->imageUploader->moveFileFromTmp($imageName);
            } catch (LocalizedException $e) {
                $this->logger->critical($e);
            }
        }

        //Remove Image
        $originalImage = $post->getOrigData('image');
        if (null !== $originalImage
            && $originalImage !== $post->getData('image')
            && $this->redundantPostImageChecker->execute($originalImage)
        ) {
            $this->file->delete($originalImage);
        }
        return $result;
    }

    /**
     * @param PostResource $subject
     * @param $result
     * @param AbstractModel $post
     * @return PostResource
     */
    public function afterDelete(PostResource $subject, $result, AbstractModel $post): PostResource
    {
        $image = $post->getData('image');
        if ($image) {
            $this->file->delete($image);
        }
        return $result;
    }
}
