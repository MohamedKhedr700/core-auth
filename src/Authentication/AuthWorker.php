<?php

namespace Raid\Core\Auth\Authentication;

use Raid\Core\Auth\Authentication\Contracts\AuthWorkerInterface;
use Raid\Core\Auth\Models\Authentication\Contracts\AccountableInterface;
use Raid\Core\Auth\Models\Authentication\Contracts\AccountInterface;

abstract class AuthWorker implements AuthWorkerInterface
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
     * Get the query column name.
     */
    public function getQueryColumn(AccountableInterface $accountable, array $credentials): string
    {
        return static::queryColumn() ?: static::worker();
    }

    /**
     * Get the worker credential value.
     */
    public function getWorkerValue(array $credentials): string
    {
        return $credentials[static::worker()];
    }

    /**
     * Find a worker account.
     */
    public function find(AccountableInterface $accountable, array $credentials): ?AccountInterface
    {
        $column = $this->getQueryColumn($accountable, $credentials);

        $value = $this->getWorkerValue($credentials);

        return $accountable->findAccount($column, $value);
    }
}
