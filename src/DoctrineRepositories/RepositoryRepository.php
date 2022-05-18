<?php

namespace App\DoctrineRepositories;

use App\Entity\Repository;
use App\Entity\User;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Repository|null findByName(string $name, ?array $orderBy = null)
 */
class RepositoryRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Repository::class);
    }

    public function findAllExistentRepository(User $user): array
    {
        $qb = $this->createQueryBuilder('re');

        $rawResults = $qb->select('re.externalId, re.id')
            ->where('re.user = :user')
            ->setParameter('user', $user)
            ->getQuery()
            ->getResult();
        $results = [];
        array_map(function (array $repository) use (&$results): void {
            $results[$repository['externalId']] = $repository['id'];
        }, $rawResults);

        return $results;
    }

    public function findOneByName(string $name, User $user): Repository
    {
        $qb = $this->createQueryBuilder('re');

        return $qb->where('re.name = :name')
            ->andWhere('re.user = :user')
            ->setParameter('name', $name)
            ->setParameter('user', $user)
            ->getQuery()
            ->getOneOrNullResult();
    }
}
