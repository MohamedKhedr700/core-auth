<?php

namespace Raid\Core\Auth\Authentication\Login;

use Raid\Core\Auth\Authentication\Contracts\Login\LoginManagerInterface;

abstract class LoginRuler
{
    /**
     * Run login ruler.
     */
    public function rule(LoginManagerInterface $loginManager): bool
    {
        return true;
    }
}