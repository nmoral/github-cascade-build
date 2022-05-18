<?php

namespace App\Repositories;

use App\DoctrineRepositories\RepositoryRepository;
use App\Dto\Github\GithubRepositoriesCollection;
use App\Entity\RepositoriesCollection;
use App\Entity\Repository;
use App\Entity\User;
use App\Provider\Github\GithubRepositoriesClient;

class GithubRepositories
{
    private GithubRepositoriesClient $client;

    private RepositoryRepository $repositoryRepository;

    /**
     * @param GithubRepositoriesClient $client
     * @param RepositoryRepository $repositoryRepository
     */
    public function __construct(GithubRepositoriesClient $client, RepositoryRepository $repositoryRepository)
    {
        $this->client = $client;
        $this->repositoryRepository = $repositoryRepository;
    }

    public function create(User $user): RepositoriesCollection
    {
        $repositoriesDtoCollection = $this->fetch($user);

        $existentIds = $this->repositoryRepository->findAllExistentRepository($user);

        $collection = new RepositoriesCollection();
        foreach ($repositoriesDtoCollection as $repositoriesDto) {
            $repository = Repository::createFromGithub($repositoriesDto, $user, $existentIds[$repositoriesDto->id] ?? null);
            $this->repositoryRepository->persist($repository);

            $collection->add($repository);
        }


        return $collection;
    }

    private function fetch(User $user): GithubRepositoriesCollection
    {
        return $this->client->fetch($user);
    }
}
