<?php

use Behat\Behat\Hook\Scope\BeforeStepScope;
use Behat\MinkExtension\Context\MinkContext;

/**
 * Created by PhpStorm.
 * User: toufik
 * Date: 23/04/18
 * Time: 13:07
 */

class FeatureContext extends MinkContext
{
    /**
     * @BeforeStep
     */
    public function configureLiveCoverageId(BeforeStepScope $scope)
    {
        /*$featureFile = $scope->getFeature()->getFile();
        $coverageId = pathinfo($featureFile, PATHINFO_FILENAME);
        $this->getSession()->setCookie('coverage_id', $coverageId);*/
    }

}