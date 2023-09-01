<?php

namespace Raid\Core\AuthAuthentication\Contracts\Login;

use Raid\Core\AuthAuthentication\Contracts\AccountInterface;

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
