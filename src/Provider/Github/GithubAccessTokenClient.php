<?php

namespace App\Provider\Github;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GithubAccessTokenClient
{
    private HttpClientInterface $client;


    private string $githubClient;

    private string $githubSecret;

    /**
     * @param HttpClientInterface $client
     * @param string $githubClient
     * @param string $githubSecret
     */
    public function __construct(
        HttpClientInterface $client,
        string $githubClient,
        string $githubSecret
    ) {
        $this->client = $client;
        $this->githubClient = $githubClient;
        $this->githubSecret = $githubSecret;
    }

    /**
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     */
    public function fetch(string $code): string
    {
        $response = $this->client->request(
            Request::METHOD_POST,
            'https://github.com/login/oauth/access_token',
            [
                'headers' => [
                    'Accept' => 'application/json',
                ],
                'body' => [
                    'client_id'     => $this->githubClient,
                    'client_secret' => $this->githubSecret,
                    'code'          => $code,
                ],
            ]
        );

        $result = $response->toArray();


        return $result['access_token'];
    }
}
