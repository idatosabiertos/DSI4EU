<?php

namespace DSI\UseCase;

use abeautifulsite\SimpleImage;
use DSI\Entity\Image;
use DSI\NotEnoughData;
use DSI\NotFound;
use DSI\Repository\UserRepo;
use DSI\Service\ErrorHandler;

class UploadTempImage
{
    /** @var ErrorHandler */
    private $errorHandler;

    /** @var UploadTempImage_Data */
    private $data;

    /** @var UserRepo */
    private $userRepo;

    /** @var string */
    private $imagePath;

    public function __construct()
    {
        $this->data = new UploadTempImage_Data();
    }

    public function exec()
    {
        $this->errorHandler = new ErrorHandler();
        $this->userRepo = new UserRepo();

        $this->checkIfAllTheInfoHaveBeenSent();
        $this->checkIfFileExistsOnServer();
        $this->checkFilename();

        $fileInfo = new \SplFileInfo($this->data()->fileName);

        $this->checkFileExtension($fileInfo);

        if ($this->data()->format == 'profilePic') {
            $img = new SimpleImage($this->data()->filePath);
            $img->thumbnail(200, 200)
                ->save($this->data()->filePath, null, $fileInfo->getExtension());
        }
        if ($this->data()->format == 'projectLogo') {
            $img = new SimpleImage($this->data()->filePath);
            $img->thumbnail(200, 200)
                ->save($this->data()->filePath, null, $fileInfo->getExtension());
        }

        $this->imagePath = md5($this->data()->fileName . uniqid('', true)) . '.' . strtolower($fileInfo->getExtension());
        rename($this->data()->filePath, Image::TEMP_FOLDER . $this->imagePath);
        chmod(Image::TEMP_FOLDER . $this->imagePath, 0777);
    }

    /**
     * @return UploadTempImage_Data
     */
    public function data()
    {
        return $this->data;
    }

    /**
     * @return string
     */
    public function getImagePath()
    {
        return $this->imagePath;
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
    }
}

class UploadTempImage_Data
{
    /** @var string */
    public $filePath,
        $fileName,
        $format;
}