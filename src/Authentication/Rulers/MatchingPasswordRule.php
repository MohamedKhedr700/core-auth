<?php

namespace Raid\Core\Auth\Authentication\Rulers;


use Raid\Core\Auth\Authentication\Contracts\AuthManagerInterface;
use Raid\Core\Auth\Authentication\Contracts\AuthRulerInterface;

class MatchingPasswordRule implements AuthRulerInterface
{
    /**
     * Run login ruler.
     */
    public function rule(AuthManagerInterface $loginManager): bool
    {
        if ($loginManager->account()->isMatchingPassword($loginManager->credentials('password',''))) {
            return true;
        }

        $loginManager->errors()->add('error', __('auth.not_found'));

        return false;
    }
}
