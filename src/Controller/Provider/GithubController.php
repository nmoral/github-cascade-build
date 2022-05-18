<?php

namespace App\Controller\Provider;

use App\Account\GithubAccount;
use App\Repository\AccountRepository;
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
            'scope'        => 'write:packages workflow user',
            'state'        => bin2hex(random_bytes(20)),
        ];

        return new RedirectResponse('https://github.com/login/oauth/authorize?'.http_build_query($params));
    }

    #[Route(path: '/redirect', name: 'redirect')]
    public function redirect(
        GithubRedirectRequest $request,
        GithubAccount $githubAccount,
        AccountRepository $accountRepository,
        RouterInterface $router
    ): Response
    {
        $account = $githubAccount->create($request);

        $accountRepository->persist($account);
        $accountRepository->flush();

        return new RedirectResponse($router->generate('dashboard'));
    }

}
