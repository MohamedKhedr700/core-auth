<?php

namespace Raid\Core\Auth\Authentication\Rulers;


use Raid\Core\Auth\Authentication\Contracts\AuthChannelInterface;
use Raid\Core\Auth\Authentication\Contracts\AuthRuleInterface;

class MatchingPasswordRule implements AuthRuleInterface
{
    /**
     * Run authentication ruler.
     */
    public function rule(AuthChannelInterface $authChannel): bool
    {
        if ($authChannel->account()->isMatchingPassword($authChannel->credentials('password',''))) {
            return true;
        }

        $authChannel->errors()->add('error', __('auth.not_found'));

        return false;
    }
}
