<?php

namespace Raid\Core\Auth\Authentication;

use Raid\Core\Auth\Authentication\Contracts\AuthenticatableInterface;
use Raid\Core\Auth\Authentication\Contracts\AuthWorkerInterface;
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
     * {@inheritdoc}
     */
    public static function worker(): string
    {
        return static::WORKER;
    }

    /**
     * {@inheritdoc}
     */
    public static function queryColumn(): string
    {
        return static::QUERY_COLUMN;
    }

    /**
     * {@inheritdoc}
     */
    public function getQueryColumn(AuthenticatableInterface $authenticatable, array $credentials): string
    {
        return static::queryColumn() ?: static::worker();
    }

    /**
     * {@inheritdoc}
     */
    public function getWorkerValue(array $credentials): string
    {
        return $credentials[static::worker()];
    }

    /**
     * {@inheritdoc}
     */
    public function find(AuthenticatableInterface $authenticatable, array $credentials): ?AccountInterface
    {
        $column = $this->getQueryColumn($authenticatable, $credentials);

        $value = $this->getWorkerValue($credentials);

        return $authenticatable->getAccount($column, $value);
    }
}
