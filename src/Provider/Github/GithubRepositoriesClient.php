<?php

namespace App\Provider\Github;

use App\Dto\Github\GithubRepositoriesCollection;
use App\Entity\Account;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GithubRepositoriesClient
{
    private HttpClientInterface $client;

    /**
     * @param HttpClientInterface $client
     */
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function fetch(User $user): GithubRepositoriesCollection
    {
        $response = $this->client->request(
            Request::METHOD_GET,
            sprintf('https://api.github.com/user/repos'),
            [
                'headers' => [
                    'Accept' => 'application/vnd.github.v3+json',
                    'Authorization' => sprintf('bearer %s', $user->accessToken),
                ]
            ]
        );

        return GithubRepositoriesCollection::create($response->toArray());
    }
}
