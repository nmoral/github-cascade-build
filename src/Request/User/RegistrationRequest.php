<?php

namespace App\Request\User;

use App\Entity\User;
use App\DoctrineRepositories\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class RegistrationRequest
{
    private UserRepository $repository;

    private RequestStack $requestStack;

    public function __construct(UserRepository $repository, RequestStack $requestStack)
    {
        $this->repository = $repository;
        $this->requestStack = $requestStack;
    }

    public function getUser(): User
    {
        return $this->repository->find($this->get('id'));
    }

    private function get(string $key): mixed
    {
        return $this->request()->get($key);
    }

    public function request(): Request
    {
        return $this->requestStack->getMainRequest();
    }
}
