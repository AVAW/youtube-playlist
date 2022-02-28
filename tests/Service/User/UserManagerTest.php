<?php

declare(strict_types=1);

namespace App\Tests\Service\User;

use App\Entity\User\User;
use App\Service\User\UserManager;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserManagerTest extends KernelTestCase
{
    public function testCreateSuccess()
    {
        self::bootKernel();

        $container = self::$container;

        $userManager = $container->get(UserManager::class);

        $res = $userManager->create('arek test case');

        $this->assertInstanceOf(User::class, $res);
    }
}
