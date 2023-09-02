<?php

namespace Raid\Core\Auth\Authentication\Contracts\Login;

use Raid\Core\Auth\Authentication\Contracts\AccountInterface;

interface LoginManagerInterface
{
    /**
     * Get column name.
     */
    public static function column(): string;

    /**
     * Fetch user with login manager if exists.
     */
    public function fetchUser(object $accountable, array $credentials): ?AccountInterface;
}
