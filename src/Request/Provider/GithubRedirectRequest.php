<?php

namespace App\Request\Provider;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RequestStack;

class GithubRedirectRequest
{
    private RequestStack $requestStack;

    public function __construct(RequestStack $requestStack)
    {
        $this->requestStack = $requestStack;
    }

    public function getCode(): string
    {
        return $this->get('code');
    }

    private function get(string $key): mixed
    {
        return $this->request()->get($key);
    }

    private function request(): Request
    {
        return $this->requestStack->getMainRequest();
    }
}
