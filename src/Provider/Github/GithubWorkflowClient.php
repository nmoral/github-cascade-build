<?php

namespace App\Provider\Github;

use App\Dto\Github\GithubWorkflowCollection;
use App\Request\Repository\WorkflowRequest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GithubWorkflowClient
{
    private HttpClientInterface $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @throws TransportExceptionInterface
     * @throws ServerExceptionInterface
     * @throws RedirectionExceptionInterface
     * @throws DecodingExceptionInterface
     * @throws ClientExceptionInterface
     */
    public function fetch(WorkflowRequest $request): GithubWorkflowCollection
    {
        $user = $request->getUser();
        $response = $this->client->request(
            Request::METHOD_GET,
            sprintf(
                'https://api.github.com/repos/%s/%s/actions/workflows',
                $user->atOrganization(),
                $request->getName()
            ),
            [
                'headers' => [
                    'Accept' => 'application/vnd.github.v3+json',
                    'Authorization' => sprintf('bearer %s', $user->accessToken),
                ]
            ]
        );

        return GithubWorkflowCollection::create($response->toArray());
    }
}
