<?php

namespace Raid\Core\Auth\Authentication\Login;

use Raid\Core\Auth\Authentication\Contracts\Login\LoginWorkerInterface;
use Raid\Core\Auth\Models\Authentication\Contracts\AccountableInterface;
use Raid\Core\Auth\Models\Authentication\Contracts\AccountInterface;

abstract class LoginWorker implements LoginWorkerInterface
{
    /**
     * Login worker name.
     */
    public const WORKER = '';

    /**
     * Query column.
     */
    public const QUERY_COLUMN = '';

    /**
     * Get the worker name.
     */
    public static function worker(): string
    {
        return static::WORKER;
    }

    /**
     * Get the query column.
     */
    public static function queryColumn(): string
    {
        return static::QUERY_COLUMN;
    }

    /**
     * Get the column name.
     */
    public function getColumn(AccountableInterface $accountable, array $credentials): string
    {
        return static::queryColumn() ?: static::worker();
    }

    /**
     * Get the credential value.
     */
    public function getCredentialValue(array $credentials): string
    {
        return $credentials[static::worker()];
    }

    /**
     * Find a worker account.
     */
    public function find(AccountableInterface $accountable, array $credentials): ?AccountInterface
    {
        $column = $this->getColumn($accountable, $credentials);

        $value = $this->getCredentialValue($credentials);

        return $accountable->findAccount($column, $value);
    }
}
