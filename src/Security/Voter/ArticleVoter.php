<?php

namespace App\Security\Voter;

use App\Entity\Main\Article;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Authorization\Voter\Voter;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class ArticleVoter extends Voter
{
    public const EDIT = 'EDIT';
    public const DELETE = 'DELETE';
    private Security $security;

    public function __construct(  Security $security)
    {
        $this->security = $security;
    }

    protected function supports(string $attribute, $subject): bool
    {
        return in_array($attribute, [self::EDIT, self::DELETE])
            && $subject instanceof  Article;
    }

    protected function voteOnAttribute(string $attribute, $subject, TokenInterface $token): bool
    {
        $user = $token->getUser();
        // if the user is anonymous, do not grant access
        if (!$user instanceof UserInterface) {
            return false;
        }

        // ... (check conditions and return true to grant permission) ...
        return match ($attribute) {
            self::EDIT => $subject->getAccount() === $user || $this->security->IsGranted('ROLE_ADMIN'),
            self::DELETE => $subject->getAccount() === $user || $this->security->isGranted('ROLE_SUPER_ADMIN'),
            default => false,
        };
    }
}
