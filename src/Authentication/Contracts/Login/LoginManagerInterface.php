<?php

namespace Raid\Core\Auth\Authentication\Contracts\Login;

use Raid\Core\Auth\Authentication\Contracts\AccountInterface;

interface LoginManagerInterface
{
    /**
     * Get login manager name.
     */
    public static function manager(): string;

    /**
     * Fetch user with login manager if exists.
     */
    public function fetchUser(object $accountable, array $credentials): ?AccountInterface;
}
