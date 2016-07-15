<?php

use DSI\Entity\CaseStudy;

require_once __DIR__ . '/../../../config.php';

class CaseStudyTest extends \PHPUnit_Framework_TestCase
{
    /** @var CaseStudy */
    private $caseStudy;

    public function setUp()
    {
        $this->caseStudy = new CaseStudy();
    }

    /** @test */
    public function settingAnId_returnsTheId()
    {
        $this->caseStudy->setId(1);
        $this->assertEquals(1, $this->caseStudy->getId());
    }

    /** @test setId */
    public function settingAnInvalidId_throwsException()
    {
        $this->setExpectedException(\InvalidArgumentException::class);
        $this->caseStudy->setId(0);
    }

    /** @test */
    public function settingTitle_returnsTitle()
    {
        $this->assertEquals('', $this->caseStudy->getTitle());

        $title = 'Case Study Title';
        $this->caseStudy->setTitle($title);
        $this->assertEquals($title, $this->caseStudy->getTitle());
    }

    /** @test */
    public function settingIntroCardText_returnsIntroCardText()
    {
        $this->assertEquals('', $this->caseStudy->getIntroCardText());

        $introCardText = 'Intro Text';
        $this->caseStudy->setIntroCardText($introCardText);
        $this->assertEquals($introCardText, $this->caseStudy->getIntroCardText());
    }

    /** @test */
    public function settingIntroPageText_returnsIntroPageText()
    {
        $this->assertEquals('', $this->caseStudy->getIntroPageText());

        $introPageText = 'Intro Text';
        $this->caseStudy->setIntroPageText($introPageText);
        $this->assertEquals($introPageText, $this->caseStudy->getIntroPageText());
    }

    /** @test */
    public function settingMainText_returnsMainText()
    {
        $this->assertEquals('', $this->caseStudy->getMainText());

        $mainText = 'Main Text';
        $this->caseStudy->setMainText($mainText);
        $this->assertEquals($mainText, $this->caseStudy->getMainText());
    }

    /** @test */
    public function settingProjectStartDate_returnsProjectStartDate()
    {
        $this->assertEquals('', $this->caseStudy->getProjectStartDate());

        $date = '2016-10-10';
        $this->caseStudy->setProjectStartDate($date);
        $this->assertEquals($date, $this->caseStudy->getProjectStartDate());
    }

    /** @test */
    public function settingProjectEndDate_returnsProjectEndDate()
    {
        $this->assertEquals('', $this->caseStudy->getProjectEndDate());

        $date = '2016-10-10';
        $this->caseStudy->setProjectEndDate($date);
        $this->assertEquals($date, $this->caseStudy->getProjectEndDate());
    }

    /** @test */
    public function settingUrl_returnsUrl()
    {
        $this->assertEquals('', $this->caseStudy->getUrl());

        $url = 'http://example.org';
        $this->caseStudy->setUrl($url);
        $this->assertEquals($url, $this->caseStudy->getUrl());
    }

    /** @test */
    public function settingButtonLabel_returnsButtonLabel()
    {
        $this->assertEquals('', $this->caseStudy->getButtonLabel());

        $label = 'View Project';
        $this->caseStudy->setButtonLabel($label);
        $this->assertEquals($label, $this->caseStudy->getButtonLabel());
    }

    /** @test */
    public function settingLogo_returnsLogo()
    {
        $this->assertEquals('', $this->caseStudy->getLogo());

        $logo = 'DSC100.JPG';
        $this->caseStudy->setLogo($logo);
        $this->assertEquals($logo, $this->caseStudy->getLogo());
    }

    /** @test */
    public function settingCardImage_returnsCardImage()
    {
        $this->assertEquals('', $this->caseStudy->getCardImage());

        $image = 'DSC100.JPG';
        $this->caseStudy->setCardImage($image);
        $this->assertEquals($image, $this->caseStudy->getCardImage());
    }

    /** @test */
    public function settingHeaderImage_returnsHeaderImage()
    {
        $this->assertEquals('', $this->caseStudy->getHeaderImage());

        $bgImage = 'DSC100.JPG';
        $this->caseStudy->setHeaderImage($bgImage);
        $this->assertEquals($bgImage, $this->caseStudy->getHeaderImage());
    }

    /** @test */
    public function settingCardColour_returnsCardColour()
    {
        $this->assertEquals('', $this->caseStudy->getCardColour());

        $colour = '#ffffff';
        $this->caseStudy->setCardColour($colour);
        $this->assertEquals($colour, $this->caseStudy->getCardColour());
    }
}