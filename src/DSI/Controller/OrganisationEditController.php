<?php

namespace DSI\Controller;

use DSI\Entity\Image;
use DSI\Entity\Organisation;
use DSI\Entity\OrganisationLink_Service;
use DSI\Entity\OrganisationProject;
use DSI\Entity\User;
use DSI\Repository\OrganisationLinkRepository;
use DSI\Repository\OrganisationMemberRepository;
use DSI\Repository\OrganisationMemberRequestRepository;
use DSI\Repository\OrganisationProjectRepository;
use DSI\Repository\OrganisationRepository;
use DSI\Repository\OrganisationSizeRepository;
use DSI\Repository\OrganisationTagRepository;
use DSI\Repository\OrganisationTypeRepository;
use DSI\Repository\ProjectRepository;
use DSI\Repository\TagForOrganisationsRepository;
use DSI\Repository\UserRepository;
use DSI\Service\Auth;
use DSI\Service\ErrorHandler;
use DSI\Service\URL;
use DSI\UseCase\AddMemberInvitationToOrganisation;
use DSI\UseCase\AddMemberRequestToOrganisation;
use DSI\UseCase\AddProjectToOrganisation;
use DSI\UseCase\AddTagToOrganisation;
use DSI\UseCase\ApproveMemberRequestToOrganisation;
use DSI\UseCase\CreateProject;
use DSI\UseCase\RejectMemberRequestToOrganisation;
use DSI\UseCase\RemoveMemberFromOrganisation;
use DSI\UseCase\RemoveTagFromOrganisation;
use DSI\UseCase\UpdateOrganisation;
use DSI\UseCase\UpdateOrganisationCountryRegion;

class OrganisationEditController
{
    /** @var  int */
    public $organisationID;

    /** @var string */
    public $format = 'html';

    public function exec()
    {
        $loggedInUser = null;

        $authUser = new Auth();
        $authUser->ifNotLoggedInRedirectTo(URL::login());

        $userRepo = new UserRepository();
        $loggedInUser = $userRepo->getById($authUser->getUserId());

        $organisationRepo = new OrganisationRepository();
        $organisation = $organisationRepo->getById($this->organisationID);

        $organisationTypes = (new OrganisationTypeRepository())->getAll();
        $organisationSizes = (new OrganisationSizeRepository())->getAll();

        try {
            if (isset($_POST['saveDetails'])) {
                if ($_POST['step'] == 'step1') {
                    $updateOrganisation = new UpdateOrganisation();
                    $updateOrganisation->data()->organisation = $organisation;
                    $updateOrganisation->data()->executor = $loggedInUser;
                    $updateOrganisation->data()->name = $_POST['name'] ?? '';
                    $updateOrganisation->data()->url = $_POST['url'] ?? '';
                    $updateOrganisation->data()->organisationTypeId = $_POST['organisationTypeId'] ?? 0;
                    $updateOrganisation->data()->tags = $_POST['tags'] ?? [];
                    $updateOrganisation->data()->projects = $_POST['projects'] ?? [];
                    $updateOrganisation->data()->links = $_POST['links'] ?? [];
                    $updateOrganisation->exec();
                } elseif ($_POST['step'] == 'step2') {
                    $updateOrganisation = new UpdateOrganisation();
                    $updateOrganisation->data()->organisation = $organisation;
                    $updateOrganisation->data()->executor = $loggedInUser;
                    $updateOrganisation->data()->startDate = $_POST['startDate'] ?? '';
                    $updateOrganisation->data()->countryID = $_POST['countryID'] ?? 0;
                    $updateOrganisation->data()->region = $_POST['region'] ?? '';
                    $updateOrganisation->exec();
                } elseif ($_POST['step'] == 'step3') {
                    $updateOrganisation = new UpdateOrganisation();
                    $updateOrganisation->data()->organisation = $organisation;
                    $updateOrganisation->data()->executor = $loggedInUser;
                    $updateOrganisation->data()->shortDescription = $_POST['shortDescription'] ?? '';
                    $updateOrganisation->data()->description = $_POST['description'] ?? '';
                    $updateOrganisation->exec();
                } elseif ($_POST['step'] == 'step4') {
                    $updateOrganisation = new UpdateOrganisation();
                    $updateOrganisation->data()->organisation = $organisation;
                    $updateOrganisation->data()->executor = $loggedInUser;
                    $updateOrganisation->data()->logo = $_POST['logo'] ?? '';
                    $updateOrganisation->data()->headerImage = $_POST['headerImage'] ?? '';
                    $updateOrganisation->exec();
                }

                echo json_encode(['code' => 'ok']);
                return;
            }

            if (isset($_POST['updateBasic'])) {
                $authUser->ifNotLoggedInRedirectTo(URL::login());

                $updateOrganisation = new UpdateOrganisation();
                $updateOrganisation->data()->organisation = $organisation;
                $updateOrganisation->data()->executor = $loggedInUser;
                if (isset($_POST['name']))
                    $updateOrganisation->data()->name = $_POST['name'];
                if (isset($_POST['description']))
                    $updateOrganisation->data()->description = $_POST['description'];
                $updateOrganisation->data()->address = $_POST['address'];
                if (isset($_POST['organisationTypeId']) AND $_POST['organisationTypeId'])
                    $updateOrganisation->data()->organisationTypeId = $_POST['organisationTypeId'];
                if (isset($_POST['organisationSizeId']) AND $_POST['organisationSizeId'])
                    $updateOrganisation->data()->organisationSizeId = $_POST['organisationSizeId'];

                $updateOrganisation->exec();
                echo json_encode(['result' => 'ok']);
                return;
            }

            if (isset($_POST['addTag'])) {
                $addTagCmd = new AddTagToOrganisation();
                $addTagCmd->data()->organisationID = $organisation->getId();
                $addTagCmd->data()->tag = $_POST['addTag'];
                $addTagCmd->exec();
                echo json_encode(['result' => 'ok']);
                return;
            }
            if (isset($_POST['removeTag'])) {
                $removeTagCmd = new RemoveTagFromOrganisation();
                $removeTagCmd->data()->organisationID = $organisation->getId();
                $removeTagCmd->data()->tag = $_POST['removeTag'];
                $removeTagCmd->exec();
                echo json_encode(['result' => 'ok']);
                return;
            }

            if (isset($_POST['addMember'])) {
                $addMemberToOrgCmd = new AddMemberInvitationToOrganisation();
                $addMemberToOrgCmd->data()->organisationID = $organisation->getId();
                $addMemberToOrgCmd->data()->userID = $_POST['addMember'];
                $addMemberToOrgCmd->exec();
                echo json_encode(['result' => 'ok']);
                return;
            }
            if (isset($_POST['removeMember'])) {
                $removeMemberFromOrgCmd = new RemoveMemberFromOrganisation();
                $removeMemberFromOrgCmd->data()->organisationID = $organisation->getId();
                $removeMemberFromOrgCmd->data()->userID = $_POST['removeMember'];
                $removeMemberFromOrgCmd->exec();
                echo json_encode(['result' => 'ok']);
                return;
            }

            if (isset($_POST['requestToJoin'])) {
                $addMemberRequestToJoinOrganisation = new AddMemberRequestToOrganisation();
                $addMemberRequestToJoinOrganisation->data()->organisationID = $organisation->getId();
                $addMemberRequestToJoinOrganisation->data()->userID = $loggedInUser->getId();
                $addMemberRequestToJoinOrganisation->exec();
                echo json_encode(['result' => 'ok']);
                return;
            }
            if (isset($_POST['approveRequestToJoin'])) {
                $approveMemberRequestToJoinOrganisation = new ApproveMemberRequestToOrganisation();
                $approveMemberRequestToJoinOrganisation->data()->organisationID = $organisation->getId();
                $approveMemberRequestToJoinOrganisation->data()->userID = $_POST['approveRequestToJoin'];
                $approveMemberRequestToJoinOrganisation->exec();
                echo json_encode(['result' => 'ok']);
                return;
            }
            if (isset($_POST['rejectRequestToJoin'])) {
                $rejectMemberRequestToJoinOrganisation = new RejectMemberRequestToOrganisation();
                $rejectMemberRequestToJoinOrganisation->data()->organisationID = $organisation->getId();
                $rejectMemberRequestToJoinOrganisation->data()->userID = $_POST['rejectRequestToJoin'];
                $rejectMemberRequestToJoinOrganisation->exec();
                echo json_encode(['result' => 'ok']);
                return;
            }

            if (isset($_POST['updateCountryRegion'])) {
                $createProjectCmd = new UpdateOrganisationCountryRegion();
                $createProjectCmd->data()->organisationID = $organisation->getId();
                $createProjectCmd->data()->countryID = $_POST['countryID'];
                $createProjectCmd->data()->region = $_POST['region'];
                $createProjectCmd->exec();
                echo json_encode(['result' => 'ok']);
                return;
            }

            if (isset($_POST['createProject'])) {
                $createProjectCmd = new CreateProject();
                $createProjectCmd->data()->name = $_POST['createProject'];
                $createProjectCmd->data()->owner = $loggedInUser;
                $createProjectCmd->exec();
                $project = $createProjectCmd->getProject();

                $addOrganisationProjectCmd = new AddProjectToOrganisation();
                $addOrganisationProjectCmd->data()->projectID = $project->getId();
                $addOrganisationProjectCmd->data()->organisationID = $organisation->getId();
                $addOrganisationProjectCmd->exec();

                echo json_encode([
                    'result' => 'ok',
                    'url' => URL::project($project),
                ]);
                return;
            }

        } catch (ErrorHandler $e) {
            echo json_encode([
                'code' => 'error',
                'errors' => $e->getErrors()
            ]);
            return;
        }

        $memberRequests = [];
        $isOwner = false;
        $canUserRequestMembership = false;

        $organisationMembers = (new OrganisationMemberRepository())->getMembersForOrganisation($organisation->getId());
        $organisationProjects = (new OrganisationProjectRepository())->getByOrganisationID($organisation->getId());
        $partnerOrganisations = (new OrganisationProjectRepository())->getPartnerOrganisationsFor($organisation);

        if ($loggedInUser) {
            $canUserRequestMembership = $this->canUserRequestMembership($organisation, $loggedInUser);
            if ($organisation->getOwner()->getId() == $loggedInUser->getId())
                $isOwner = true;

            if (isset($isOwner) AND $isOwner === true)
                $memberRequests = (new OrganisationMemberRequestRepository())->getMembersForOrganisation($organisation->getId());
        }

        if ($this->format == 'json') {
            $owner = $organisation->getOwner();
            $links = [];
            $organisationLinks = (new OrganisationLinkRepository())->getByOrganisationID($organisation->getId());
            foreach ($organisationLinks AS $organisationLink) {
                if ($organisationLink->getLinkService() == OrganisationLink_Service::Facebook)
                    $links['facebook'] = $organisationLink->getLink();
                if ($organisationLink->getLinkService() == OrganisationLink_Service::Twitter)
                    $links['twitter'] = $organisationLink->getLink();
                if ($organisationLink->getLinkService() == OrganisationLink_Service::GooglePlus)
                    $links['googleplus'] = $organisationLink->getLink();
                if ($organisationLink->getLinkService() == OrganisationLink_Service::GitHub)
                    $links['github'] = $organisationLink->getLink();
            }

            echo json_encode([
                'name' => $organisation->getName(),
                'url' => $organisation->getUrl(),
                'shortDescription' => $organisation->getShortDescription(),
                'description' => $organisation->getDescription(),
                'address' => $organisation->getAddress(),
                'organisationTypeId' => (string)$organisation->getOrganisationTypeId(),
                'organisationSizeId' => (string)$organisation->getOrganisationSizeId(),
                'startDate' => $organisation->getStartDate(),
                'logo' => $organisation->getLogo() ?
                    Image::ORGANISATION_LOGO_URL . $organisation->getLogo() : '',
                'headerImage' => $organisation->getHeaderImage() ?
                    Image::ORGANISATION_HEADER_URL . $organisation->getHeaderImage() : '',

                'members' => array_values(array_filter(array_map(function (User $user) use ($owner) {
                    if ($owner->getId() == $user->getId())
                        return null;
                    else
                        return [
                            'id' => $user->getId(),
                            'text' => $user->getFirstName() . ' ' . $user->getLastName(),
                            'firstName' => $user->getFirstName(),
                            'lastName' => $user->getLastName(),
                            'profilePic' => $user->getProfilePicOrDefault()
                        ];
                }, $organisationMembers))),
                'memberRequests' => array_map(function (User $user) {
                    return [
                        'id' => $user->getId(),
                        'text' => $user->getFirstName() . ' ' . $user->getLastName(),
                        'firstName' => $user->getFirstName(),
                        'lastName' => $user->getLastName(),
                        'profilePic' => $user->getProfilePicOrDefault()
                    ];
                }, $memberRequests),
                'organisationProjects' => array_map(function (OrganisationProject $organisationProject) {
                    $project = $organisationProject->getProject();
                    return [
                        'id' => $project->getId(),
                        'name' => $project->getName(),
                        'organisationsCount' => $project->getOrganisationsCount(),
                        'url' => URL::project($project),
                    ];
                }, $organisationProjects),
                'partnerOrganisations' => array_map(function (Organisation $organisation) {
                    return [
                        'id' => $organisation->getId(),
                        'name' => $organisation->getName(),
                        'commonProjects' => $organisation->extraData['common-projects'],
                        'url' => URL::organisation($organisation),
                    ];
                }, $partnerOrganisations),
                'countryID' => $organisation->getCountryID(),
                'region' => $organisation->getRegionName(),
                'links' => $links ? $links : '',
            ]);
            return;
        } else {
            $pageTitle = $organisation->getName();
            $angularModules['fileUpload'] = true;
            $tags = (new TagForOrganisationsRepository())->getAll();
            $orgTags = (new OrganisationTagRepository())->getTagsNameByOrganisationID($organisation->getId());
            $projects = (new ProjectRepository())->getAll();
            $orgProjects = (new OrganisationProjectRepository())->getProjectIDsForOrganisation($organisation->getId());
            require __DIR__ . '/../../../www/organisation-edit.php';
        }
    }

    private function canUserRequestMembership(Organisation $organisation, User $loggedInUser)
    {
        if ($organisation->getOwner()->getId() == $loggedInUser->getId())
            return false;
        if ((new OrganisationMemberRepository())->organisationHasMember($organisation->getId(), $loggedInUser->getId()))
            return false;
        if ((new OrganisationMemberRequestRepository())->organisationHasRequestFromMember($organisation->getId(), $loggedInUser->getId()))
            return false;

        return true;
    }
}