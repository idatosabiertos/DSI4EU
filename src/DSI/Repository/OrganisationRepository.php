<?php

namespace DSI\Repository;

use DSI;
use DSI\Entity\Organisation;
use DSI\Service\SQL;

class OrganisationRepository
{
    public function insert(Organisation $organisation)
    {
        $insert = array();
        $insert[] = "`ownerID` = '" . addslashes($organisation->getOwner()->getId()) . "'";
        $insert[] = "`name` = '" . addslashes($organisation->getName()) . "'";
        $insert[] = "`description` = '" . addslashes($organisation->getDescription()) . "'";
        if ($organisation->getCountry())
            $insert[] = "`countryID` = '" . addslashes($organisation->getCountry()->getId()) . "'";
        if ($organisation->getCountryRegion())
            $insert[] = "`countryRegionID` = '" . addslashes($organisation->getCountryRegion()->getId()) . "'";
        $insert[] = "`address` = '" . addslashes($organisation->getAddress()) . "'";
        if ($organisation->getOrganisationType())
            $insert[] = "`organisationTypeID` = '" . addslashes($organisation->getOrganisationTypeId()) . "'";
        if ($organisation->getOrganisationSize())
            $insert[] = "`organisationSizeID` = '" . addslashes($organisation->getOrganisationSizeId()) . "'";
        $insert[] = "`projectsCount` = '" . (int)($organisation->getProjectsCount()) . "'";
        $insert[] = "`partnersCount` = '" . (int)($organisation->getPartnersCount()) . "'";
        $insert[] = "`importID` = '" . addslashes($organisation->getImportID()) . "'";

        $query = new SQL("INSERT INTO `organisations` SET " . implode(', ', $insert) . "");
        $query->query();

        $organisation->setId($query->insert_id());
    }

    public function save(Organisation $organisation)
    {
        $query = new SQL("SELECT id FROM `organisations` WHERE id = '{$organisation->getId()}' LIMIT 1");
        $existingOrg = $query->fetch();
        if (!$existingOrg)
            throw new DSI\NotFound('organisationID: ' . $organisation->getId());

        $insert = array();
        $insert[] = "`ownerID` = '" . addslashes($organisation->getOwner()->getId()) . "'";
        $insert[] = "`name` = '" . addslashes($organisation->getName()) . "'";
        $insert[] = "`description` = '" . addslashes($organisation->getDescription()) . "'";
        if ($organisation->getCountry())
            $insert[] = "`countryID` = '" . addslashes($organisation->getCountry()->getId()) . "'";
        if ($organisation->getCountryRegion())
            $insert[] = "`countryRegionID` = '" . addslashes($organisation->getCountryRegion()->getId()) . "'";
        if ($organisation->getOrganisationType())
            $insert[] = "`organisationTypeID` = '" . addslashes($organisation->getOrganisationTypeId()) . "'";
        $insert[] = "`address` = '" . addslashes($organisation->getAddress()) . "'";
        if ($organisation->getOrganisationSize())
            $insert[] = "`organisationSizeID` = '" . addslashes($organisation->getOrganisationSizeId()) . "'";
        $insert[] = "`projectsCount` = '" . (int)($organisation->getProjectsCount()) . "'";
        $insert[] = "`partnersCount` = '" . (int)($organisation->getPartnersCount()) . "'";
        $insert[] = "`importID` = '" . addslashes($organisation->getImportID()) . "'";

        $query = new SQL("UPDATE `organisations` SET " . implode(', ', $insert) . " WHERE `id` = '{$organisation->getId()}'");
        $query->query();
    }

    public function getById(int $id): Organisation
    {
        return $this->getObjectWhere([
            "`id` = {$id}"
        ]);
    }

    public function getByImportID(string $importID): Organisation
    {
        return $this->getObjectWhere([
            "`importID` = '" . addslashes($importID) . "'"
        ]);
    }

    private function buildObjectFromData($organisation)
    {
        $organisationObj = new Organisation();
        $organisationObj->setId($organisation['id']);

        $organisationObj->setOwner(
            (new UserRepository())->getById($organisation['ownerID'])
        );
        $organisationObj->setName($organisation['name']);
        $organisationObj->setDescription($organisation['description']);
        if ($organisation['countryRegionID']) {
            $organisationObj->setCountryRegion(
                (new CountryRegionRepository())->getById($organisation['countryRegionID'])
            );
        }
        $organisationObj->setAddress($organisation['address']);
        if ($organisation['organisationTypeID']) {
            $organisationObj->setOrganisationType(
                (new OrganisationTypeRepository())->getById($organisation['organisationTypeID'])
            );
        }
        if ($organisation['organisationSizeID']) {
            $organisationObj->setOrganisationSize(
                (new OrganisationSizeRepository())->getById($organisation['organisationSizeID'])
            );
        }
        $organisationObj->setProjectsCount($organisation['projectsCount']);
        $organisationObj->setPartnersCount($organisation['partnersCount']);
        $organisationObj->setImportID($organisation['importID']);

        return $organisationObj;
    }

    /**
     * @return Organisation[]
     */
    public function getAll()
    {
        return $this->getObjectsWhere(["1"]);
    }

    public function clearAll()
    {
        $query = new SQL("TRUNCATE TABLE `organisations`");
        $query->query();
    }

    private function getObjectWhere($where)
    {
        $objects = $this->getObjectsWhere($where);

        if (count($objects) < 1)
            throw new DSI\NotFound();

        return $objects[0];
    }

    /**
     * @param $where
     * @return array
     */
    private function getObjectsWhere($where)
    {
        $organisations = [];
        $query = new SQL("SELECT 
            id, ownerID, name, description
          , countryRegionID, address
          , organisationTypeID, organisationSizeID
          , projectsCount, partnersCount
          , importID
          FROM `organisations` 
          WHERE " . implode(' AND ', $where) . "
          ORDER BY `name`
        ");
        foreach ($query->fetch_all() AS $dbOrganisation) {
            $organisations[] = $this->buildObjectFromData($dbOrganisation);
        }
        return $organisations;
    }

    public function countOrganisations()
    {
        return $this->countObjectsWhere(['1']);
    }

    /**
     * @param $where
     * @return array
     */
    private function countObjectsWhere($where)
    {
        $query = new SQL("SELECT count(id) AS `total`
          FROM `organisations`
          WHERE " . implode(' AND ', $where) . "
        ");
        return $query->fetch('total');
    }
}