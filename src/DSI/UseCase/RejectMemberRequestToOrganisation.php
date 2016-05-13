<?php

namespace DSI\UseCase;

use DSI\Entity\OrganisationMember;
use DSI\Entity\OrganisationMemberRequest;
use DSI\Repository\OrganisationMemberRepository;
use DSI\Repository\OrganisationMemberRequestRepository;
use DSI\Repository\OrganisationRepository;
use DSI\Repository\UserRepository;
use DSI\Service\ErrorHandler;

class RejectMemberRequestToOrganisation
{
    /** @var ErrorHandler */
    private $errorHandler;

    /** @var OrganisationMemberRequestRepository */
    private $organisationMemberRequestRepo;

    /** @var OrganisationMemberRepository */
    private $organisationMemberRepo;

    /** @var OrganisationRepository */
    private $organisationRepository;

    /** @var UserRepository */
    private $userRepository;

    /** @var RejectMemberRequestToOrganisation_Data */
    private $data;

    public function __construct()
    {
        $this->data = new RejectMemberRequestToOrganisation_Data();
    }

    public function exec()
    {
        $this->errorHandler = new ErrorHandler();
        $this->organisationMemberRequestRepo = new OrganisationMemberRequestRepository();
        $this->organisationMemberRepo = new OrganisationMemberRepository();
        $this->organisationRepository = new OrganisationRepository();
        $this->userRepository = new UserRepository();

        if (!$this->organisationMemberRequestRepo->organisationHasRequestFromMember($this->data()->organisationID, $this->data()->userID)) {
            $this->errorHandler->addTaggedError('member', 'This user has not made a request to join the organisation');
            $this->errorHandler->throwIfNotEmpty();
        }

        $member = $this->userRepository->getById($this->data()->userID);
        $organisation = $this->organisationRepository->getById($this->data()->organisationID);

        $organisationMemberRequest = new OrganisationMemberRequest();
        $organisationMemberRequest->setMember($member);
        $organisationMemberRequest->setOrganisation($organisation);
        $this->organisationMemberRequestRepo->remove($organisationMemberRequest);
    }

    /**
     * @return RejectMemberRequestToOrganisation_Data
     */
    public function data()
    {
        return $this->data;
    }
}

class RejectMemberRequestToOrganisation_Data
{
    /** @var int */
    public $userID;

    /** @var int */
    public $organisationID;
}