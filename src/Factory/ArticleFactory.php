<?php

namespace App\Factory;

use App\Entity\Main\Account;
use App\Entity\Main\Article;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\ModelFactory;

final class ArticleFactory extends ModelFactory
{
    protected function getDefaults(): array
    {
        return [
            'photo' => self::faker()->imageUrl(), // random image URL
            'content' => self::faker()->paragraphs(1, true), // random content
            'createdAt' => self::faker()->dateTimeThisMonth(),
            'likes' => self::faker()->numberBetween(0, 1000),
            'account' => AccountFactory::random(),
        ];
    }

    protected static function getClass(): string
    {
        return Article::class;
    }
}