<?php

namespace DSI\UseCase;

use DSI\Entity\ProjectMemberInvitation;
use DSI\Entity\User;
use DSI\Repository\ProjectMemberRepository;
use DSI\Repository\ProjectMemberInvitationRepository;
use DSI\Repository\ProjectRepository;
use DSI\Repository\UserRepository;
use DSI\Service\ErrorHandler;
use Guzzle\Common\Exception\InvalidArgumentException;

class RejectMemberInvitationToProject
{
    /** @var ErrorHandler */
    private $errorHandler;

    /** @var ProjectMemberInvitationRepository */
    private $projectMemberInvitationRepo;

    /** @var ProjectMemberRepository */
    private $projectMemberRepo;

    /** @var ProjectRepository */
    private $projectRepository;

    /** @var UserRepository */
    private $userRepository;

    /** @var RejectMemberInvitationToProject_Data */
    private $data;

    public function __construct()
    {
        $this->data = new RejectMemberInvitationToProject_Data();
    }

    public function exec()
    {
        $this->errorHandler = new ErrorHandler();
        $this->projectMemberInvitationRepo = new ProjectMemberInvitationRepository();
        $this->projectMemberRepo = new ProjectMemberRepository();
        $this->projectRepository = new ProjectRepository();
        $this->userRepository = new UserRepository();

        $this->assertExecutorIsSet();
        $this->assertExecutorCanExecute();
        $this->assertUserHasBeenInvited();

        $member = $this->userRepository->getById($this->data()->userID);
        $project = $this->projectRepository->getById($this->data()->projectID);

        $this->deleteMemberInvitation($member, $project);
    }

    /**
     * @return RejectMemberInvitationToProject_Data
     */
    public function data()
    {
        return $this->data;
    }

    private function assertUserHasBeenInvited()
    {
        if (!$this->projectMemberInvitationRepo->memberHasInvitationToProject($this->data()->userID, $this->data()->projectID)) {
            $this->errorHandler->addTaggedError('member', 'This user was not invited to join the project');
            $this->errorHandler->throwIfNotEmpty();
        }
    }

    private function assertExecutorIsSet()
    {
        if (!$this->data()->executor OR $this->data()->executor->getId() < 1)
            throw new InvalidArgumentException('executor');
    }

    private function assertExecutorCanExecute()
    {
        if ($this->data()->executor->getId() != $this->data()->userID) {
            $this->errorHandler->addTaggedError('executor', 'Only the invited person can approve the invitation');
            throw $this->errorHandler;
        }
    }

    /**
     * @param $member
     * @param $project
     * @throws \DSI\NotFound
     */
    private function deleteMemberInvitation($member, $project)
    {
        $projectMemberInvitation = new ProjectMemberInvitation();
        $projectMemberInvitation->setMember($member);
        $projectMemberInvitation->setProject($project);
        $this->projectMemberInvitationRepo->remove($projectMemberInvitation);
    }
}

class RejectMemberInvitationToProject_Data
{
    /** @var User */
    public $executor;

    /** @var int */
    public $userID;

    /** @var int */
    public $projectID;
}