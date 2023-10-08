<?php

namespace Raid\Core\Auth\Authentication\Contracts;

interface AuthRuleInterface
{
    /**
     * Run an authentication rule.
     */
    public function rule(AuthManagerInterface $authManager): bool;
}
