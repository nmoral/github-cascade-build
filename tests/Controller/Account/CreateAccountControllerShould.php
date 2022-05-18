<?php

namespace App\Tests\Controller\Account;

use App\Controller\Account\AccountCreationController;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Response;
use Twig\Environment;

class CreateAccountControllerShould extends TestCase
{
    /**
     * @test
     */
    public function returnAResponse(): void
    {
        $controller = new AccountCreationController();

        $response = $controller->onboarding($this->createMock(Environment::class));

        self::assertInstanceOf(Response::class, $response);
    }
}
