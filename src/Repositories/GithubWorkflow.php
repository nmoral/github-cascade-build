<?php

namespace App\Repositories;

use App\DoctrineRepositories\WorkflowRepository;
use App\Dto\Github\GithubWorkflowCollection;
use App\Entity\Workflow;
use App\Entity\WorkFlowsCollection;
use App\Provider\Github\GithubWorkflowClient;
use App\Request\Repository\WorkflowRequest;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class GithubWorkflow
{
    private GithubWorkflowClient $workflowClient;

    private WorkflowRepository $workflowRepository;

    /**
     * @param GithubWorkflowClient $workflowClient
     * @param WorkflowRepository $workflowRepository
     */
    public function __construct(GithubWorkflowClient $workflowClient, WorkflowRepository $workflowRepository)
    {
        $this->workflowClient = $workflowClient;
        $this->workflowRepository = $workflowRepository;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function create(WorkflowRequest $request): WorkFlowsCollection
    {
        $workflowsCollection = $this->fetch($request);
        $existentIds = $this->workflowRepository->findAllExistentWorkflow($request);
        $collection = new WorkFlowsCollection();
        foreach ($workflowsCollection as $workflowDto) {
            $workflow = Workflow::createFromGithub($workflowDto, $request, $existentIds[$workflowDto->id] ?? null);
            $this->workflowRepository->persist($workflow);

            $collection->add($workflow);
        }

        return $collection;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    private function fetch(WorkflowRequest $request): GithubWorkflowCollection
    {
        return $this->workflowClient->fetch($request);
    }
}
