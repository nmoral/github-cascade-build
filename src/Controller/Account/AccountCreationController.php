<?php

namespace App\Controller\Account;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class AccountCreationController
{
    #[Route(path: '/onboarding', name: 'onboarding', methods: [Request::METHOD_GET])]
    public function onboarding(Environment $twig): Response
    {
        return new Response($twig->render('account/onboarding.html.twig'));
    }
}
