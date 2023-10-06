<?php

namespace Raid\Core\Auth\Authentication\Contracts\Login;

use Raid\Core\Auth\Authentication\Contracts\AccountInterface;

interface LoginManagerInterfaceOld
{
    /**
     * Get login manager name.
     */
    public static function manager(): string;

    /**
     * Get query column.
     */
    public static function queryColumn(): string;

    /**
     * Get column name.
     */
    public function getColumn(object $accountable, array $credentials): string;

    /**
     * Get credential value.
     */
    public function getCredentialValue(array $credentials): string;

    /**
     * Find an account with login manager if exists.
     */
    public function findAccount(object $accountable, array $credentials): ?AccountInterface;
}
