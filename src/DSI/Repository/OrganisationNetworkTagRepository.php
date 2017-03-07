<?php

namespace DSI\Repository;

use DSI\DuplicateEntry;
use DSI\Entity\Organisation;
use DSI\Entity\OrganisationNetworkTag;
use DSI\NotFound;
use DSI\Service\SQL;

class OrganisationNetworkTagRepository
{
    private $table = 'organisation-network-tags';
    /** @var OrganisationRepository */
    private $organisationRepo;

    /** @var NetworkTagRepository */
    private $tagsRepo;

    public function __construct()
    {
        $this->organisationRepo = new OrganisationRepositoryInAPC();
        $this->tagsRepo = new NetworkTagRepository();
    }

    public function add(OrganisationNetworkTag $organisationNetworkTag)
    {
        $query = new SQL("SELECT organisationID 
            FROM `{$this->table}`
            WHERE `organisationID` = '{$organisationNetworkTag->getOrganisationID()}'
            AND `tagID` = '{$organisationNetworkTag->getTagID()}'
            LIMIT 1
        ");
        if ($query->fetch('organisationID') > 0)
            throw new DuplicateEntry("organisationID: {$organisationNetworkTag->getOrganisationID()} / tagID: {$organisationNetworkTag->getTagID()}");

        $insert = array();
        $insert[] = "`organisationID` = '" . (int)($organisationNetworkTag->getOrganisationID()) . "'";
        $insert[] = "`tagID` = '" . (int)($organisationNetworkTag->getTagID()) . "'";

        $query = new SQL("INSERT INTO `{$this->table}` SET " . implode(', ', $insert) . "");
        // $query->pr();
        $query->query();
    }

    public function remove(OrganisationNetworkTag $organisationNetworkTag)
    {
        $query = new SQL("SELECT organisationID 
            FROM `{$this->table}`
            WHERE `organisationID` = '{$organisationNetworkTag->getOrganisationID()}'
            AND `tagID` = '{$organisationNetworkTag->getTagID()}'
            LIMIT 1
        ");
        if (!$query->fetch('organisationID'))
            throw new NotFound("organisationID: {$organisationNetworkTag->getOrganisationID()} / tagID: {$organisationNetworkTag->getTagID()}");

        $insert = array();
        $insert[] = "`organisationID` = '" . (int)($organisationNetworkTag->getOrganisationID()) . "'";
        $insert[] = "`tagID` = '" . (int)($organisationNetworkTag->getTagID()) . "'";

        $query = new SQL("DELETE FROM `{$this->table}` WHERE " . implode(' AND ', $insert) . "");
        $query->query();
    }

    /**
     * @param int $organisationID
     * @return \DSI\Entity\OrganisationNetworkTag[]
     */
    public function getByOrganisationID(int $organisationID)
    {
        return $this->getObjectsWhere([
            "`organisationID` = '{$organisationID}'"
        ]);
    }

    /**
     * @param Organisation $organisation
     * @return \int[]
     */
    public function getTagIDsForOrganisation(Organisation $organisation)
    {
        $where = [
            "`organisationID` = '{$organisation->getId()}'"
        ];

        /** @var int[] $tagIDs */
        $tagIDs = [];
        $query = new SQL("SELECT tagID 
            FROM `{$this->table}`
            WHERE " . implode(' AND ', $where) . "
            ORDER BY tagID
        ");
        foreach ($query->fetch_all() AS $dbOrganisationTags) {
            $tagIDs[] = $dbOrganisationTags['tagID'];
        }

        return $tagIDs;
    }

    /**
     * @param int $tagID
     * @return \DSI\Entity\OrganisationNetworkTag[]
     */
    public function getByTagID(int $tagID)
    {
        return $this->getObjectsWhere([
            "`tagID` = '{$tagID}'"
        ]);
    }

    /**
     * @param int $tagID
     * @return \int[]
     */
    public function getOrganisationIDsForTag(int $tagID)
    {
        $where = [
            "`tagID` = '{$tagID}'"
        ];

        /** @var int[] $organisationIDs */
        $organisationIDs = [];
        $query = new SQL("SELECT organisationID 
            FROM `{$this->table}`
            WHERE " . implode(' AND ', $where) . "
            ORDER BY organisationID
        ");
        foreach ($query->fetch_all() AS $dbOrganisationTag) {
            $organisationIDs[] = $dbOrganisationTag['organisationID'];
        }

        return $organisationIDs;
    }

    public function clearAll()
    {
        $query = new SQL("TRUNCATE TABLE `{$this->table}`");
        $query->query();
    }

    /**
     * @param $where
     * @return \DSI\Entity\OrganisationNetworkTag[]
     */
    private function getObjectsWhere($where)
    {
        /** @var OrganisationNetworkTag[] $organisationTags */
        $organisationTags = [];
        $query = new SQL("SELECT organisationID, tagID 
            FROM `{$this->table}`
            WHERE " . implode(' AND ', $where) . "
        ");
        foreach ($query->fetch_all() AS $dbOrganisationTag) {
            $organisationTag = new OrganisationNetworkTag();
            $organisationTag->setOrganisation($this->organisationRepo->getById($dbOrganisationTag['organisationID']));
            $organisationTag->setTag($this->tagsRepo->getById($dbOrganisationTag['tagID']));
            $organisationTags[] = $organisationTag;
        }

        return $organisationTags;
    }

    public function organisationHasTagName(int $organisationID, string $tagName)
    {
        $organisationTags = $this->getByOrganisationID($organisationID);
        foreach ($organisationTags AS $organisationTag) {
            if ($tagName == $organisationTag->getTag()->getName()) {
                return true;
            }
        }

        return false;
    }

    public function getTagNamesByOrganisation(Organisation $organisation)
    {
        $query = new SQL("SELECT tag 
            FROM `network-tags` 
            LEFT JOIN `{$this->table}` ON `network-tags`.`id` = `{$this->table}`.`tagID`
            WHERE `{$this->table}`.`organisationID` = '{$organisation->getId()}'
            ORDER BY `network-tags`.`tag`
        ");
        return $query->fetch_all('tag');
    }
}