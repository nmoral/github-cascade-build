<?php

namespace App\DoctrineRepositories;

use App\Entity\User;
use App\Entity\Workflow;
use App\Request\Repository\WorkflowRequest;
use Doctrine\Persistence\ManagerRegistry;

class WorkflowRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Workflow::class);
    }

    public function findAllExistentWorkflow(WorkflowRequest $request): array
    {
        $qb = $this->createQueryBuilder('w');

        $rawResults = $qb
            ->select('w.externalId, w.id')
            ->where('w.user = :user')
            ->andWhere('w.repository = :repository')
            ->setParameter('user', $request->getUser())
            ->setParameter('repository', $request->getRepository())
            ->getQuery()
            ->getResult();

        $results = [];
        array_map(function (array $repository) use (&$results): void {
            $results[$repository['externalId']] = $repository['id'];
        }, $rawResults);

        return $results;
    }
}
