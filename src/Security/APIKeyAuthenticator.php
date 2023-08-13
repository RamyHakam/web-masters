<?php

namespace App\Security;

use App\Repository\Main\AccountRepository;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class APIKeyAuthenticator extends AbstractAuthenticator
{
    use TargetPathTrait;

    private AccountRepository $accountRepository;

    public function __construct(AccountRepository $accountRepository)
    {
        $this->accountRepository = $accountRepository;
    }

    public function supports(Request $request): ?bool
    {
        return  $request->headers->has('X-AUTH-TOKEN');
    }

    public function authenticate(Request $request): Passport
    {
         $apiKey = $request->headers->get('X-AUTH-TOKEN');
          return new SelfValidatingPassport(new UserBadge($apiKey, function ($apiKey) {
                 $email = base64_decode($apiKey);
                return $this->accountRepository->findOneBy(['email' => $email]);
            }));
          }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        if ($targetPath = $this->getTargetPath($request->getSession(), $firewallName))
        {
            return new RedirectResponse($targetPath);
        }
        return new JsonResponse(['success' => true]);
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new JsonResponse(['success' => false, 'message' => strtr($exception->getMessageKey(), $exception->getMessageData())], 401);
    }
}
