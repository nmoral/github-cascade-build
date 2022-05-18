<?php

namespace App\Controller\Dashboard;

use App\DoctrineRepositories\RepositoryRepository;
use App\Repositories\GithubRepositories;
use App\Request\Dashboard\DashboardRequest;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Environment;

class DashboardController
{
    #[Route(path: '', name: 'dashboard')]
    public function dashboard(
        Environment $twig,
        DashboardRequest $request,
        GithubRepositories $githubRepositories,
        RepositoryRepository $repositoryRepository,
    ): Response {
        $githubRepositoriesCollection = $githubRepositories->create($request->getCurrentUser());
        $repositoryRepository->flush();

        return new Response($twig->render('dashboard/dashboard.html.twig', [
            'repositories' => $githubRepositoriesCollection,
        ]));
    }
}
