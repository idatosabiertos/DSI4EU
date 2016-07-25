<?php

namespace DSI\Controller;

use DSI\AccessDenied;
use DSI\Entity\Image;
use DSI\Entity\Project;
use DSI\Entity\ProjectLink_Service;
use DSI\Entity\User;
use DSI\Repository\ImpactTagRepository;
use DSI\Repository\OrganisationProjectRepository;
use DSI\Repository\OrganisationRepository;
use DSI\Repository\ProjectImpactTagARepository;
use DSI\Repository\ProjectImpactTagBRepository;
use DSI\Repository\ProjectImpactTagCRepository;
use DSI\Repository\ProjectLinkRepository;
use DSI\Repository\ProjectMemberRepository;
use DSI\Repository\ProjectRepository;
use DSI\Repository\ProjectTagRepository;
use DSI\Repository\TagForProjectsRepository;
use DSI\Repository\UserRepository;
use DSI\Service\Auth;
use DSI\Service\ErrorHandler;
use DSI\Service\URL;
use DSI\UseCase\UpdateProject;
use DSI\UseCase\UpdateProjectCountryRegion;
use DSI\UseCase\UpdateProjectLogo;

class ProjectEditController
{
    public $projectID;
    public $format = 'html';

    public function __construct()
    {
    }

    public function exec()
    {
        $authUser = new Auth();
        $authUser->ifNotLoggedInRedirectTo(URL::login());
        $loggedInUser = (new UserRepository())->getById($authUser->getUserId());

        $projectRepo = new ProjectRepository();
        $project = $projectRepo->getById($this->projectID);

        if (!$this->userCanModifyProject($project, $loggedInUser))
            throw new AccessDenied('You cannot access this page');

        if ($this->format == 'json') {
            try {
                if (isset($_POST['saveDetails'])) {
                    if ($_POST['step'] == 'step1') {
                        $updateProject = new UpdateProject();
                        $updateProject->data()->project = $project;
                        $updateProject->data()->executor = $loggedInUser;
                        $updateProject->data()->name = $_POST['name'] ?? '';
                        $updateProject->data()->url = $_POST['url'] ?? '';
                        $updateProject->data()->tags = $_POST['tags'] ?? [];
                        $updateProject->data()->impactTagsA = $_POST['impactTagsA'] ?? [];
                        $updateProject->data()->impactTagsB = $_POST['impactTagsB'] ?? [];
                        $updateProject->data()->impactTagsC = $_POST['impactTagsC'] ?? [];
                        $updateProject->data()->links = $_POST['links'] ?? [];
                        $updateProject->exec();
                    } elseif ($_POST['step'] == 'step2') {
                        $updateProject = new UpdateProject();
                        $updateProject->data()->project = $project;
                        $updateProject->data()->executor = $loggedInUser;
                        $updateProject->data()->startDate = $_POST['startDate'] ?? '';
                        $updateProject->data()->endDate = $_POST['endDate'] ?? '';
                        $updateProject->data()->countryID = $_POST['countryID'] ?? 0;
                        $updateProject->data()->region = $_POST['region'] ?? '';
                        $updateProject->exec();
                    } elseif ($_POST['step'] == 'step3') {
                        $updateProject = new UpdateProject();
                        $updateProject->data()->project = $project;
                        $updateProject->data()->executor = $loggedInUser;
                        $updateProject->data()->shortDescription = $_POST['shortDescription'] ?? '';
                        $updateProject->data()->description = $_POST['description'] ?? '';
                        $updateProject->data()->socialImpact = $_POST['socialImpact'] ?? '';
                        $updateProject->exec();
                    } elseif ($_POST['step'] == 'step4') {
                        $updateProject = new UpdateProject();
                        $updateProject->data()->project = $project;
                        $updateProject->data()->executor = $loggedInUser;
                        $updateProject->data()->logo = $_POST['logo'] ?? '';
                        $updateProject->data()->headerImage = $_POST['headerImage'] ?? '';
                        $updateProject->exec();
                    }

                    echo json_encode(['code' => 'ok']);
                    return;
                }
            } catch (ErrorHandler $e) {
                echo json_encode([
                    'result' => 'error',
                    'errors' => $e->getErrors()
                ]);
                return;
            }

            $owner = $project->getOwner();
            $links = [];
            $projectLinks = (new ProjectLinkRepository())->getByProjectID($project->getId());
            foreach ($projectLinks AS $projectLink) {
                if ($projectLink->getLinkService() == ProjectLink_Service::Facebook)
                    $links['facebook'] = $projectLink->getLink();
                if ($projectLink->getLinkService() == ProjectLink_Service::Twitter)
                    $links['twitter'] = $projectLink->getLink();
                if ($projectLink->getLinkService() == ProjectLink_Service::GooglePlus)
                    $links['googleplus'] = $projectLink->getLink();
                if ($projectLink->getLinkService() == ProjectLink_Service::GitHub)
                    $links['github'] = $projectLink->getLink();
            }

            echo json_encode([
                'name' => $project->getName(),
                'url' => $project->getUrl(),
                'status' => $project->getStatus(),
                'description' => $project->getDescription(),
                'startDate' => $project->getStartDate(),
                //'startDateHumanReadable' => $project->getUnixStartDate() ? date('l, j F, Y', $project->getUnixStartDate()) : '',
                'endDate' => $project->getEndDate(),
                //'endDateHumanReadable' => $project->getUnixEndDate() ? date('l, j F, Y', $project->getUnixEndDate()) : '',
                'countryID' => $project->getCountryID(),
                'region' => $project->getRegionName(),
                'logo' => $project->getLogo() ?
                    Image::PROJECT_LOGO_URL . $project->getLogo() : '',
                'headerImage' => $project->getHeaderImage() ?
                    Image::PROJECT_HEADER_URL . $project->getHeaderImage() : '',
                'links' => $links ? $links : '',
            ]);
            return;

        } else {
            $data = ['project' => $project];
            $tags = (new TagForProjectsRepository())->getAll();
            $impactTags = (new ImpactTagRepository())->getAll();
            $projectImpactTagsA = (new ProjectImpactTagARepository())->getTagsNameByProjectID($project->getId());
            $projectImpactTagsB = (new ProjectImpactTagBRepository())->getTagsNameByProjectID($project->getId());
            $projectImpactTagsC = (new ProjectImpactTagCRepository())->getTagsNameByProjectID($project->getId());
            $projectTags = (new ProjectTagRepository())->getTagsNameByProjectID($project->getId());
            $organisations = (new OrganisationRepository())->getAll();
            $orgProjects = (new OrganisationProjectRepository())->getOrganisationIDsForProject($project->getId());
            $angularModules['fileUpload'] = true;
            require __DIR__ . '/../../../www/project-edit.php';
        }
    }

    private function userCanModifyProject(Project $project, User $user)
    {
        if ($project->getOwner()->getId() == $user->getId())
            return true;

        if ((new ProjectMemberRepository())->projectHasMember($project->getId(), $user->getId()))
            return true;

        return false;
    }
}