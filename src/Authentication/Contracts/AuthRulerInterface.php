<?php

namespace Raid\Core\Auth\Authentication\Contracts;

interface AuthRulerInterface
{
    /**
     * Run an authentication ruler.
     */
    public function rule(AuthManagerInterface $authManager): bool;
}
