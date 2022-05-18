<?php

namespace App\Controller\Repository;

use App\DoctrineRepositories\WorkflowRepository;
use App\Repositories\GithubWorkflow;
use App\Request\Repository\WorkflowRequest;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class WorkflowController
{
    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    #[Route(path: '/repository/workflow', name: 'repository_workflow', methods: Request::METHOD_GET)]
    public function fetch(
        WorkflowRequest $request,
        GithubWorkflow $githubWorkflow,
        WorkflowRepository $repository
    ): JsonResponse {
        $workflows = $githubWorkflow->create($request);
        $repository->flush();

        return new JsonResponse($workflows);
    }
}
