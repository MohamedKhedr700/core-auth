<?php

namespace Raid\Core\Auth\Authentication\Login;

use Raid\Core\Auth\Authentication\Contracts\AccountInterface;
use Raid\Core\Auth\Authentication\Contracts\Login\LoginManagerInterface;

abstract class LoginManagerOld implements LoginManagerInterface
{
    /**
     * Login manager.
     */
    public const MANAGER = '';

    /**
     * Query column.
     */
    public const QUERY_COLUMN = '';

    /**
     * {@inheritDoc}
     */
    public static function manager(): string
    {
        return static::MANAGER;
    }

    /**
     * {@inheritDoc}
     */
    public static function queryColumn(): string
    {
        return static::QUERY_COLUMN;
    }

    /**
     * {@inheritDoc}
     */
    public function getColumn(object $accountable, array $credentials): string
    {
        return static::queryColumn() ?: static::manager();
    }

    /**
     * {@inheritDoc}
     */
    public function getCredentialValue(array $credentials): string
    {
        return $credentials[static::manager()];
    }

    /**
     * Find account.
     */
    public function findAccount(string $column, mixed $value): ?AccountInterface
    {
        return $this->where($column, $value)->first();
    }
}
