<?php

namespace DSI\UseCase;

use abeautifulsite\SimpleImage;
use DSI\NotEnoughData;
use DSI\NotFound;
use DSI\Repository\StoryRepo;
use DSI\Service\ErrorHandler;

class UpdateStoryBgImage
{
    /** @var ErrorHandler */
    private $errorHandler;

    /** @var UpdateStoryBgImage_Data */
    private $data;

    /** @var StoryRepo */
    private $storyRepo;

    /** @var string */
    private $bgImage;

    public function __construct()
    {
        $this->data = new UpdateStoryBgImage_Data();
    }

    public function exec()
    {
        $this->errorHandler = new ErrorHandler();
        $this->storyRepo = new StoryRepo();

        $this->checkIfAllTheInfoHaveBeenSent();
        $this->checkIfFileExistsOnServer();
        $this->checkFilename();

        $fileInfo = new \SplFileInfo($this->data()->fileName);

        $this->checkFileExtension($fileInfo);

        $img = new SimpleImage($this->data()->filePath);

        $this->checkImageDimensions($img);

        $img->thumbnail(200, 200)->save($this->data()->filePath, null, $fileInfo->getExtension());

        $this->bgImage = $this->data()->storyID . '-' . $this->data()->fileName;
        rename($this->data()->filePath, __DIR__ . '/../../../www/images/stories/bg/' . $this->bgImage);

        $this->updateStoryDetails();
    }

    /**
     * @return UpdateStoryBgImage_Data
     */
    public function data()
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function getBgImage()
    {
        return $this->bgImage;
    }

    private function checkFileExtension(\SplFileInfo $fileInfo)
    {
        if (!in_array(strtolower($fileInfo->getExtension()), [
            'jpg', 'jpeg', 'png'
        ])
        ) {
            $this->errorHandler->addTaggedError('file', __('Only image files are accepted') . ' (received .' . $fileInfo->getExtension() . ')');
            $this->errorHandler->throwIfNotEmpty();
        }
    }

    private function checkFilename()
    {
        if (basename($this->data()->fileName) != $this->data()->fileName) {
            $this->errorHandler->addTaggedError('file', 'Invalid file name. Try renaming the file');
            $this->errorHandler->throwIfNotEmpty();
        }
    }

    private function checkIfFileExistsOnServer()
    {
        if (!file_exists($this->data()->filePath))
            throw new NotFound('filePath');
    }

    private function checkIfAllTheInfoHaveBeenSent()
    {
        if (!isset($this->data()->filePath))
            throw new NotEnoughData('filePath');
        if (!isset($this->data()->fileName))
            throw new NotEnoughData('fileName');
        if (!isset($this->data()->storyID))
            throw new NotEnoughData('userID');
    }

    /**
     * @param $img
     * @throws ErrorHandler
     */
    private function checkImageDimensions(SimpleImage $img)
    {
        if ($img->get_height() < 100 OR $img->get_width() < 100) {
            $this->errorHandler->addTaggedError('file', __('Image must be at least 100 x 100 pixels'));
            $this->errorHandler->throwIfNotEmpty();
        }
    }

    private function updateStoryDetails()
    {
        $story = $this->storyRepo->getById($this->data()->storyID);
        $story->setMainImage($this->bgImage);
        $this->storyRepo->save($story);
    }
}

class UpdateStoryBgImage_Data
{
    /** @var string */
    public $filePath,
        $fileName;

    /** @var int */
    public $storyID;
}