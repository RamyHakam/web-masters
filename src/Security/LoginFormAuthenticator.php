<?php

namespace App\Security;

use App\Entity\Main\Account;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\CsrfTokenBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\CustomCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class LoginFormAuthenticator extends AbstractAuthenticator implements  AuthenticationEntryPointInterface
{
    use TargetPathTrait;
    private RouterInterface $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function supports(Request $request): ?bool
    {
        return($request->getPathInfo() == '/login' && $request->isMethod('POST'));
    }

    public function authenticate(Request $request): Passport
    {
        $userName = $request->request->get('account_form')['username'];
        $password = $request->request->get('account_form')['password'];
        return new Passport(
            new UserBadge($userName),
            new PasswordCredentials($password),
            [
                new CsrfTokenBadge('authenticate', $request->request->get('account_form')['_token']),
                (new RememberMeBadge())->enable()
            ]);
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        if($targetPath = $this->getTargetPath($request->getSession(), $firewallName))
            return new RedirectResponse($targetPath);
        return new RedirectResponse($this->router->generate('home_page'));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        $request->getSession()->set(Security::AUTHENTICATION_ERROR, $exception);
        return  new RedirectResponse($this->router->generate('login_page'));
    }

    public function start(Request $request, AuthenticationException $authException = null): Response
    {
        return  new RedirectResponse($this->router->generate('login_page'));
    }
}
