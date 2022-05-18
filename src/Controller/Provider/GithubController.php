<?php

namespace App\Controller\Provider;

use App\Account\GithubAccount;
use App\DoctrineRepositories\UserRepository;
use App\Request\Provider\GithubRedirectRequest;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\RouterInterface;

#[Route(path: '/provider/github', name: 'provider_github_')]
class GithubController
{
    #[Route(path: '/authorize', name: 'authorize')]
    public function authorize(string $githubClient, RouterInterface $router): Response
    {
        $params = [
            'client_id'    => $githubClient,
            'redirect_uri' => $router->generate('provider_github_redirect', [], UrlGeneratorInterface::ABSOLUTE_URL),
            'scope'        => 'write:packages workflow user repo',
            'state'        => bin2hex(random_bytes(20)),
        ];

        return new RedirectResponse('https://github.com/login/oauth/authorize?'.http_build_query($params));
    }

    /**
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     */
    #[Route(path: '/redirect', name: 'redirect')]
    public function redirect(
        GithubRedirectRequest $request,
        GithubAccount $githubAccount,
        UserRepository $userRepository,
        RouterInterface $router
    ): Response
    {
        $user = $githubAccount->create($request);

        $userRepository->persist($user);
        $userRepository->flush();

        return new RedirectResponse($router->generate('user_register', ['id' => $user->id]));
    }

}
