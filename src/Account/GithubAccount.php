<?php

namespace App\Account;

use App\Entity\Account;
use App\Provider\Github\GithubAccessToken;
use App\Provider\Github\GithubUser;
use App\Request\Provider\GithubRedirectRequest;

class GithubAccount
{
    private GithubAccessToken $githubAccessToken;

    private GithubUser $githubUser;

    public function __construct(GithubAccessToken $githubAccessToken, GithubUser $githubUser)
    {
        $this->githubAccessToken = $githubAccessToken;
        $this->githubUser = $githubUser;
    }

    /**
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     */
    public function create(GithubRedirectRequest $request): Account
    {
        $githubAccount = $this->getUser($request);

        return  Account::createFromGithub($githubAccount);
    }

    /**
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     */
    private function getUser(GithubRedirectRequest $request)
    {
        $accessToken = $this->accessToken($request);

        return $this->githubUser->get($accessToken);
    }

    /**
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     */
    private function accessToken(GithubRedirectRequest $request): string
    {
        return $this->githubAccessToken->fetch($request->getCode());
    }
}
