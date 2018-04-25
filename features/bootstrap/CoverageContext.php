<?php
/**
 * Created by PhpStorm.
 * User: toufik
 * Date: 22/04/18
 * Time: 17:04
 */

use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use SebastianBergmann\CodeCoverage\CodeCoverage;
use SebastianBergmann\CodeCoverage\Filter;
use SebastianBergmann\CodeCoverage\Report\Html\Facade;

class CoverageContext implements Context
{
    /**
     * @var CodeCoverage
     */
    private static $coverage;

    /**
     * @BeforeSuite
     */
    public static function setup()
    {
        $filter = new Filter();
        $filter->addDirectoryToWhitelist(__DIR__.'/../../src');

        static::$coverage = new CodeCoverage(null, $filter);
    }

    /**
     * @AfterSuite
     */
    public static function tearDown()
    {
        $writer = new Facade();
        $writer->process(static::$coverage, __DIR__.'/../../coverage-behat');
    }

    /**
     * @BeforeScenario
     */
    public function startCoverage(BeforeScenarioScope $scope)
    {
        static::$coverage->start("{$scope->getFeature()->getTitle()}::{$scope->getScenario()->getTitle()}");
    }

    /**
     * @AfterScenario
     */
    public function stopCoverage()
    {
        static::$coverage->stop();
    }
}