<?php

namespace Raid\Core\Auth\Authentication;

use Raid\Core\Auth\Authentication\Contracts\AuthChannelInterface;
use Raid\Core\Auth\Authentication\Contracts\AuthRuleInterface;

abstract class AuthRule implements AuthRuleInterface
{
    /**
     * {@inheritdoc}
     */
    public function rule(AuthChannelInterface $authChannel): bool
    {
        return true;
    }
}
