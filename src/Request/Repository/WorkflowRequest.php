<?php

namespace App\Request\Repository;

use App\DoctrineRepositories\RepositoryRepository;
use App\Entity\Repository;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Security\Core\Security;

class WorkflowRequest
{
    private RequestStack $requestStack;

    private Security $security;

    private RepositoryRepository $repository;

    public function __construct(
        RequestStack $requestStack,
        Security $security,
        RepositoryRepository $repository
    ) {
        $this->requestStack = $requestStack;
        $this->security = $security;
        $this->repository = $repository;
    }

    public function getUser(): User
    {
        return $this->security->getUser();
    }

    public function getName(): string
    {
        return $this->get('name');
    }

    private function get(string $key): mixed
    {
        return $this->request()->get($key);
    }

    private function request(): Request
    {
        return $this->requestStack->getMainRequest();
    }

    public function getRepository(): Repository
    {
        return $this->repository->findOneByName($this->getName(), $this->getUser());
    }
}
