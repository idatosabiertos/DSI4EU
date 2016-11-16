<?php

namespace DSI\UseCase;

use DSI\Entity\Organisation;
use DSI\Entity\OrganisationNetworkTag;
use DSI\Repository\NetworkTagRepository;
use DSI\Repository\OrganisationNetworkTagRepository;
use DSI\Service\ErrorHandler;

class AddNetworkTagToOrganisation
{
    /** @var ErrorHandler */
    private $errorHandler;

    /** @var OrganisationNetworkTagRepository */
    private $organisationNetworkTagRepo;

    /** @var String */
    private $tag;

    /** @var Organisation */
    private $organisation;

    public function exec()
    {
        $this->errorHandler = new ErrorHandler();
        $this->organisationNetworkTagRepo = new OrganisationNetworkTagRepository();

        $networkTagRepo = new NetworkTagRepository();

        if ($networkTagRepo->nameExists($this->tag)) {
            $tag = $networkTagRepo->getByName($this->tag);
        } else {
            $createTag = new CreateNetworkTag();
            $createTag->data()->name = $this->tag;
            $createTag->exec();
            $tag = $createTag->getTag();
        }

        if ($this->organisationNetworkTagRepo->organisationHasTagName($this->organisation->getId(), $this->tag)) {
            $this->errorHandler->addTaggedError('tag', 'Organisation already has this tag');
            $this->errorHandler->throwIfNotEmpty();
        }

        $organisationNetworkTag = new OrganisationNetworkTag();
        $organisationNetworkTag->setTag($tag);
        $organisationNetworkTag->setOrganisation($this->organisation);
        $this->organisationNetworkTagRepo->add($organisationNetworkTag);
    }

    /**
     * @param String $tag
     */
    public function setTag(String $tag)
    {
        $this->tag = $tag;
    }

    /**
     * @param Organisation $organisation
     */
    public function setOrganisation(Organisation $organisation)
    {
        $this->organisation = $organisation;
    }
}