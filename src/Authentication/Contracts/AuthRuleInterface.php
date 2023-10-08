<?php

namespace Raid\Core\Auth\Authentication\Contracts;

interface AuthRuleInterface
{
    /**
     * Run an authentication ruler.
     */
    public function rule(AuthManagerInterface $authManager): bool;
}