<?php

namespace App\Service;

class EncryptPasswordService
{
    public function encryptPassword(string $password): string
    {
        return password_hash($password, PASSWORD_BCRYPT);
    }
}