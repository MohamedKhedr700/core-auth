<?php

namespace Raid\Core\Auth\Authentication\Login\Rulers;


use Raid\Core\Auth\Authentication\Login\Contracts\LoginManagerInterface;
use Raid\Core\Auth\Authentication\Login\Contracts\LoginRulerInterface;

class MatchingPasswordRuler implements LoginRulerInterface
{
    /**
     * Run login ruler.
     */
    public function rule(LoginManagerInterface $loginManager): bool
    {
        if ($loginManager->account()->isMatchingPassword($loginManager->credentials('password',''))) {
            return true;
        }

        $loginManager->errors()->add('error', __('auth.not_found'));

        return false;
    }
}
