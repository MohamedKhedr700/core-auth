<?php

namespace Raid\Core\Auth\Authentication\Rulers;


use Raid\Core\Auth\Authentication\Contracts\LoginManagerInterface;
use Raid\Core\Auth\Authentication\Contracts\LoginRulerInterface;

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
