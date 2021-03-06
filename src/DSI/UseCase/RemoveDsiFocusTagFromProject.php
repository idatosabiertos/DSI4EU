<?php

namespace DSI\UseCase;

use DSI\Entity\ProjectDsiFocusTag;
use DSI\Repository\DsiFocusTagRepo;
use DSI\Repository\ProjectDsiFocusTagRepo;
use DSI\Repository\ProjectRepo;
use DSI\Repository\ProjectRepoInAPC;
use DSI\Service\ErrorHandler;

class RemoveDsiFocusTagFromProject
{
    /** @var ErrorHandler */
    private $errorHandler;

    /** @var ProjectDsiFocusTagRepo */
    private $projectDsiFocusTagRepo;

    /** @var RemoveDsiFocusTagBFromProject_Data */
    private $data;

    public function __construct()
    {
        $this->data = new RemoveDsiFocusTagBFromProject_Data();
    }

    public function exec()
    {
        $this->errorHandler = new ErrorHandler();
        $this->projectDsiFocusTagRepo = new ProjectDsiFocusTagRepo();

        $tagRepo = new DsiFocusTagRepo();
        $projectRepo = new ProjectRepoInAPC();

        if ($tagRepo->nameExists($this->data()->tag)) {
            $tag = $tagRepo->getByName($this->data()->tag);
        } else {
            $createTag = new CreateDsiFocusTag();
            $createTag->data()->name = $this->data()->tag;
            $createTag->exec();
            $tag = $createTag->getTag();
        }

        if (!$this->projectDsiFocusTagRepo->projectHasTagName($this->data()->projectID, $this->data()->tag)) {
            $this->errorHandler->addTaggedError('tag', __('Project does not have this tag'));
            $this->errorHandler->throwIfNotEmpty();
        }

        $projectTag = new ProjectDsiFocusTag();
        $projectTag->setTag($tag);
        $projectTag->setProject($projectRepo->getById($this->data()->projectID));
        $this->projectDsiFocusTagRepo->remove($projectTag);
    }

    /**
     * @return RemoveDsiFocusTagBFromProject_Data
     */
    public function data()
    {
        return $this->data;
    }
}

class RemoveDsiFocusTagBFromProject_Data
{
    /** @var string */
    public $tag;

    /** @var int */
    public $projectID;
}