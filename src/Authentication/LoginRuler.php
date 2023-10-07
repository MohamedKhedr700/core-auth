<?php

namespace Raid\Core\Auth\Authentication;

use Raid\Core\Auth\Authentication\Contracts\LoginManagerInterface;
use Raid\Core\Auth\Authentication\Contracts\LoginRulerInterface;

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
