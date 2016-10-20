<?php

namespace DSI\Controller;

use DSI\Entity\OrganisationMember;
use DSI\Entity\ProjectMember;
use DSI\Repository\OrganisationMemberRepository;
use DSI\Repository\OrganisationRepository;
use DSI\Repository\OrganisationRepositoryInAPC;
use DSI\Repository\ProjectMemberRepository;
use DSI\Repository\ProjectRepository;
use DSI\Repository\ProjectRepositoryInAPC;
use DSI\Repository\UserLanguageRepository;
use DSI\Repository\UserLinkRepository;
use DSI\Repository\UserRepository;
use DSI\Repository\UserSkillRepository;
use DSI\Service\Auth;
use DSI\Service\ErrorHandler;
use DSI\Service\URL;
use DSI\UseCase\AddLanguageToUser;
use DSI\UseCase\AddLinkToUser;
use DSI\UseCase\AddMemberRequestToOrganisation;
use DSI\UseCase\AddMemberRequestToProject;
use DSI\UseCase\AddSkillToUser;
use DSI\UseCase\RemoveLanguageFromUser;
use DSI\UseCase\RemoveLinkFromUser;
use DSI\UseCase\RemoveSkillFromUser;
use DSI\UseCase\UpdateUserBasicDetails;
use DSI\UseCase\UpdateUserBio;

class ProfileController
{
    /** @var ProfileController_Data */
    private $data;

    public function __construct()
    {
        $this->data = new ProfileController_Data();
    }

    public function exec()
    {
        $urlHandler = new URL();
        $authUser = new Auth();
        $authUser->ifNotLoggedInRedirectTo($urlHandler->login());
        $loggedInUser = $authUser->getUser();

        if(!$this->data()->userURL)
            go_to($urlHandler->profile($loggedInUser));

        $user = $this->getUserFromURL($this->data()->userURL);

        $userID = $user->getId();
        $isOwner = ($user->getId() == $loggedInUser->getId());

        if ($this->data()->format == 'json') {
            $userSkillRepo = new UserSkillRepository();
            $userLangRepo = new UserLanguageRepository();
            $userLinkRepo = new UserLinkRepository();
            $projectMemberRepo = new ProjectMemberRepository();
            $organisationMemberRepo = new OrganisationMemberRepository();

            if ($isOwner) {
                try {
                    if (isset($_POST['addSkill'])) {
                        $addSkillToUser = new AddSkillToUser();
                        $addSkillToUser->data()->userID = $user->getId();
                        $addSkillToUser->data()->skill = $_POST['addSkill'];
                        $addSkillToUser->exec();
                        return;
                    } elseif (isset($_POST['removeSkill'])) {
                        $removeSkillFromUser = new RemoveSkillFromUser();
                        $removeSkillFromUser->data()->userID = $user->getId();
                        $removeSkillFromUser->data()->skill = $_POST['removeSkill'];
                        $removeSkillFromUser->exec();
                        return;
                    } elseif (isset($_POST['addLanguage'])) {
                        $addSkillToUser = new AddLanguageToUser();
                        $addSkillToUser->data()->userID = $user->getId();
                        $addSkillToUser->data()->language = $_POST['addLanguage'];
                        $addSkillToUser->exec();
                        return;
                    } elseif (isset($_POST['removeLanguage'])) {
                        $removeLanguageFromUser = new RemoveLanguageFromUser();
                        $removeLanguageFromUser->data()->userID = $user->getId();
                        $removeLanguageFromUser->data()->language = $_POST['removeLanguage'];
                        $removeLanguageFromUser->exec();
                        return;
                    } elseif (isset($_POST['updateBio'])) {
                        $updateUserBio = new UpdateUserBio();
                        $updateUserBio->data()->userID = $user->getId();
                        $updateUserBio->data()->bio = $_POST['bio'] ?? '';
                        $updateUserBio->exec();
                        echo json_encode(['code' => 'ok']);
                        return;
                    } elseif (isset($_POST['addLink'])) {
                        $addLinkToUser = new AddLinkToUser();
                        $addLinkToUser->data()->userID = $user->getId();
                        $addLinkToUser->data()->link = $_POST['addLink'];
                        $addLinkToUser->exec();
                        return;
                    } elseif (isset($_POST['removeLink'])) {
                        $removeLinkFromUser = new RemoveLinkFromUser();
                        $removeLinkFromUser->data()->userID = $user->getId();
                        $removeLinkFromUser->data()->link = $_POST['removeLink'];
                        $removeLinkFromUser->exec();
                        return;
                    } elseif (isset($_POST['updateBasicDetails'])) {
                        $updateUserBasicDetails = new UpdateUserBasicDetails();
                        $updateUserBasicDetails->data()->userID = $user->getId();
                        $updateUserBasicDetails->data()->firstName = $_POST['firstName'] ?? '';
                        $updateUserBasicDetails->data()->lastName = $_POST['lastName'] ?? '';
                        $updateUserBasicDetails->data()->cityName = $_POST['location'] ?? '';
                        $updateUserBasicDetails->data()->jobTitle = $_POST['jobTitle'] ?? '';
                        $updateUserBasicDetails->exec();
                        echo json_encode(['code' => 'ok']);
                        return;
                    } elseif (isset($_POST['joinProject'])) {
                        $joinProject = new AddMemberRequestToProject();
                        $joinProject->data()->projectID = $_POST['project'];
                        $joinProject->data()->userID = $loggedInUser->getId();
                        $joinProject->exec();
                        echo json_encode(['code' => 'ok']);
                        return;
                    } elseif (isset($_POST['joinOrganisation'])) {
                        $joinOrganisation = new AddMemberRequestToOrganisation();
                        $joinOrganisation->data()->organisationID = $_POST['organisation'];
                        $joinOrganisation->data()->userID = $loggedInUser->getId();
                        $joinOrganisation->exec();
                        echo json_encode(['code' => 'ok']);
                        return;
                    }
                } catch (ErrorHandler $e) {
                    echo json_encode([
                        'code' => 'error',
                        'errors' => $e->getErrors()
                    ]);
                    return;
                }
            }

            echo json_encode([
                'tags' => $userSkillRepo->getSkillsNameByUserID($user->getId()),
                'languages' => $userLangRepo->getLanguagesNameByUserID($user->getId()),
                'links' => $userLinkRepo->getLinksByUserID($user->getId()),
                'user' => [
                    'firstName' => $user->getFirstName(),
                    'lastName' => $user->getLastName(),
                    'jobTitle' => $user->getJobTitle(),
                    'location' => $user->getCityName(),
                    'bio' => $user->getBio(),
                    'profilePic' => $user->getProfilePicOrDefault(),
                    'projects' => array_map(function (ProjectMember $projectMember) use ($projectMemberRepo, $urlHandler) {
                        $project = $projectMember->getProject();
                        return [
                            'name' => $project->getName(),
                            'url' => $urlHandler->project($project),
                            'membersCount' => count($projectMemberRepo->getByProjectID($project->getId())),
                        ];
                    }, $projectMemberRepo->getByMemberID($user->getId())),
                    'organisations' => array_map(function (OrganisationMember $organisationMember) use ($organisationMemberRepo, $urlHandler) {
                        $organisation = $organisationMember->getOrganisation();
                        return [
                            'name' => $organisation->getName(),
                            'url' => $urlHandler->organisation($organisation),
                            'membersCount' => count($organisationMemberRepo->getByOrganisationID($organisation->getId())),
                        ];
                    }, $organisationMemberRepo->getByMemberID($user->getId())),
                ],
            ]);
        } else {
            $projects = (new ProjectRepositoryInAPC())->getAll();
            $organisations = (new OrganisationRepositoryInAPC())->getAll();
            $userLinks = (new UserLinkRepository())->getLinksByUserID($userID);
            $angularModules['fileUpload'] = true;
            require __DIR__ . '/../../../www/views/profile.php';
        }
    }

    public function data()
    {
        return $this->data;
    }

    /**
     * @return \DSI\Entity\User
     */
    protected function getUserFromURL($url)
    {
        $userRepo = new UserRepository();
        if (ctype_digit($url)) {
            $user = $userRepo->getById((int)$url);
            return $user;
        } else {
            $user = $userRepo->getByProfileURL($url);
            return $user;
        }
    }
}

class ProfileController_Data
{
    public $userURL,
        $format = 'html';
}