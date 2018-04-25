<?php
/**
 * Created by PhpStorm.
 * User: toufik
 * Date: 24/04/18
 * Time: 00:31
 */

namespace App\Tests\Service;


use App\Entity\User;
use App\Service\UserManager;
use Doctrine\Common\Persistence\ObjectManager;
use PHPUnit\Framework\TestCase;

class UserManagerTest extends TestCase
{

    public function testUserIsSignedUp()
    {
        $userManager = $this->getMockBuilder(UserManager::class)
            ->disableOriginalConstructor()
            ->setMethods(['findOneByEmail'])
            ->getMock();

        $userManager->method('findOneByEmail')->willReturn(new User());

        $this->assertEquals(true, $userManager->isSignedUp('macron@elysee.fr'));
    }

    public function testUserIsNotSignedUp()
    {
        $userManager = $this->getMockBuilder(UserManager::class)
            ->disableOriginalConstructor()
            ->setMethods(['findOneByEmail'])
            ->getMock();

        $userManager->method('findOneByEmail')->willReturn(Null);

        $this->assertEquals(false, $userManager->isSignedUp('macron@elysee.fr'));
    }
}