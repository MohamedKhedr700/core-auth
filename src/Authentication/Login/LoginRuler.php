<?php

namespace Raid\Core\Auth\Authentication\Login;

use Raid\Core\Auth\Authentication\Login\Contracts\LoginManagerInterface;
use Raid\Core\Auth\Authentication\Login\Contracts\LoginRulerInterface;

abstract class LoginRuler implements LoginRulerInterface
{
    /**
     * Run login ruler.
     */
    public function rule(LoginManagerInterface $loginManager): bool
    {
        return true;
    }
}
