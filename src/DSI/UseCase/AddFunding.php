<?php

namespace DSI\UseCase;

use DSI\Entity\Country;
use DSI\Entity\Funding;
use DSI\Entity\FundingSource;
use DSI\NotFound;
use DSI\Repository\CountryRepository;
use DSI\Repository\FundingRepository;
use DSI\Repository\FundingSourceRepository;
use DSI\Service\ErrorHandler;

class AddFunding
{
    /** @var ErrorHandler */
    private $errorHandler;

    /** @var AddFunding_Data */
    private $data;

    /** @var FundingRepository */
    private $fundingRepository;

    /** @var FundingSource */
    private $fundingSource;

    public function __construct()
    {
        $this->data = new AddFunding_Data();
    }

    public function exec()
    {
        $this->errorHandler = new ErrorHandler();
        $this->fundingRepository = new FundingRepository();

        $this->assertDataHasBeenSubmitted();
        $this->assertDataIsNotEmpty();
        $this->assertClosingDateIsValid();
        $this->getFundingSource();

        $this->saveFunding();
    }

    /**
     * @return AddFunding_Data
     */
    public function data()
    {
        return $this->data;
    }

    private function saveFunding()
    {
        $funding = new Funding();
        $funding->setTitle($this->data()->title);
        $funding->setUrl($this->data()->url);
        $funding->setCountry((new CountryRepository())->getById($this->data()->countryID));
        if ($this->fundingSource)
            $funding->setFundingSource($this->fundingSource);
        $funding->setClosingDate($this->data()->closingDate);
        $funding->setDescription($this->data()->description);
        $this->fundingRepository->insert($funding);
    }

    private function assertDataHasBeenSubmitted()
    {
        if (!$this->data()->countryID)
            $this->errorHandler->addTaggedError('country', 'Invalid country');
        if (!$this->data()->fundingSource)
            $this->errorHandler->addTaggedError('fundingSource', 'Invalid funding source');

        $this->errorHandler->throwIfNotEmpty();
    }

    private function assertDataIsNotEmpty()
    {
        if (!$this->data()->title OR $this->data()->title == '')
            $this->errorHandler->addTaggedError('title', 'Please specify a title');
        if (!$this->data()->url OR $this->data()->url == '')
            $this->errorHandler->addTaggedError('url', 'Please specify the url');
        if (!$this->data()->description OR $this->data()->description == '')
            $this->errorHandler->addTaggedError('description', 'Please specify a desription');

        $this->errorHandler->throwIfNotEmpty();
    }

    private function assertClosingDateIsValid()
    {
        if ($this->data()->closingDate AND $this->data()->closingDate != '')
            if (!preg_match('<^\d{4}\-\d{2}\-\d{2}$>', $this->data()->closingDate))
                $this->errorHandler->addTaggedError('closingDate', 'Please specify a valid date');

        $this->errorHandler->throwIfNotEmpty();
    }

    private function getFundingSource()
    {
        if ($this->data()->fundingSource) {
            $fundingSourceRepository = new FundingSourceRepository();
            try {
                $this->fundingSource = $fundingSourceRepository->getByTitle($this->data()->fundingSource);
            } catch (NotFound $e) {
                $this->fundingSource = new FundingSource();
                $this->fundingSource->setTitle($this->data()->fundingSource);
                $fundingSourceRepository->insert($this->fundingSource);
            }
        }
    }
}

class AddFunding_Data
{
    /** @var string */
    public $title,
        $url,
        $description;

    /** @var int */
    public $countryID;

    /** @var string */
    public $fundingSource;

    /** @var string */
    public $closingDate;
}