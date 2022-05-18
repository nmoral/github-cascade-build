<?php

namespace App\Account;

use App\Entity\Account;
use App\Entity\User;
use App\Provider\Github\GithubAccessTokenClient;
use App\Provider\Github\GithubUserClient;
use App\Request\Provider\GithubRedirectRequest;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

class GithubAccount
{
    private GithubAccessTokenClient $githubAccessToken;

    private GithubUserClient $githubUser;

    public function __construct(GithubAccessTokenClient $githubAccessToken, GithubUserClient $githubUser)
    {
        $this->githubAccessToken = $githubAccessToken;
        $this->githubUser = $githubUser;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function create(GithubRedirectRequest $request): User
    {
        $githubAccount = $this->getUser($request);

        $account =  Account::createFromGithub($githubAccount);

        return User::createFromGithub($githubAccount, $account);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    private function getUser(GithubRedirectRequest $request)
    {
        $accessToken = $this->accessToken($request);

        return $this->githubUser->get($accessToken);
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    private function accessToken(GithubRedirectRequest $request): string
    {
        return $this->githubAccessToken->fetch($request->getCode());
    }
}
