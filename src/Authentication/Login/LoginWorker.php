<?php

namespace Raid\Core\Auth\Authentication\Login;

use Raid\Core\Auth\Authentication\Contracts\AccountableInterface;
use Raid\Core\Auth\Authentication\Contracts\AccountInterface;

abstract class LoginWorker
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
     * {@inheritDoc}
     */
    public static function worker(): string
    {
        return static::WORKER;
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
    public function getColumn(AccountableInterface $accountable, array $credentials): string
    {
        return static::queryColumn() ?: static::worker();
    }

    /**
     * {@inheritDoc}
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

        $accountable->findAccount($column, $value);

        return $accountable->where($column, $value)->first();
    }
}