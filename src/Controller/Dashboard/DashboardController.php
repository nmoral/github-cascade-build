<?php

namespace App\Controller\Dashboard;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController
{
    #[Route(path: '', name: 'dashboard')]
    public function dashboard(): Response
    {
        return new Response();
    }
}
