<?php

namespace Raid\Core\Auth\Authentication;

use Raid\Core\Auth\Authentication\Contracts\AuthManagerInterface;
use Raid\Core\Auth\Authentication\Contracts\AuthRuleInterface;

abstract class AuthRule implements AuthRuleInterface
{
    /**
     * {@inheritdoc}
     */
    public function rule(AuthManagerInterface $authManager): bool
    {
        return true;
    }
}
