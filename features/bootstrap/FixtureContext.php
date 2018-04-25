<?php

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use Behat\MinkExtension\Context\MinkContext;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Symfony2Extension\Context\KernelDictionary;
use Doctrine\Common\DataFixtures\Executor\ORMExecutor;
use Doctrine\Common\DataFixtures\Purger\ORMPurger;
use Doctrine\ORM\EntityManager;
use Symfony\Bridge\Doctrine\DataFixtures\ContainerAwareLoader;


/**
 * This context class contains the definitions of the steps used by the demo 
 * feature file. Learn how to get started with Behat and BDD on Behat's website.
 * 
 * @see http://behat.org/en/latest/quick_start.html
 */
class FixtureContext extends RawMinkContext
{
    use KernelDictionary;

    private $executor;
    private $purger;

    public function __construct(EntityManager $em)
    {
        $this->executor = new ORMExecutor($em, $this->purger = new ORMPurger($em));
    }

    /**
     * @BeforeScenario
     */
    public function clearDatabase()
    {
        $this->purger->purge();
    }
    /**
     * @Given the following fixtures are loaded:
     */
    public function theFollowingFixturesAreLoaded(TableNode $classnames):void
    {
        $path = __DIR__.'/../../src/DataFixtures';
        $loader = new ContainerAwareLoader($this->getContainer());

        foreach ($classnames->getRows() as $classname){
            $loader->loadFromFile(sprintf('%s/%s.php', $path, $classname[0]));
        }

        $fixtures = $loader->getFixtures();
        if (!$fixtures) {
            throw new InvalidArgumentException(
                sprintf('Could not find any fixtures to load in: %s', "\n\n- ".implode("\n- ", $fixtures))
            );
        }

        $this->executor->execute($fixtures);

    }
}
