<?php

namespace App\Provider\Github;

use App\Dto\Github\GithubUserDto;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GithubUserClient
{
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function get(string $accessToken): GithubUserDto
    {
        $response = $this->client->request(
            Request::METHOD_GET,
            'https://api.github.com/user',
            [
                'headers' => [
                    'Accept' => 'application/json',
                    'Authorization' => sprintf('bearer %s', $accessToken),
                ]
            ]
        );

        return GithubUserDto::create($response->toArray(), $accessToken);
    }
}
