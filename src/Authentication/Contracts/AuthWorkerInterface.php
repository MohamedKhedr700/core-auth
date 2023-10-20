<?php

namespace Raid\Core\Auth\Authentication\Contracts;

use Raid\Core\Auth\Models\Authentication\Contracts\AccountInterface;

interface AuthWorkerInterface
{
    /**
     * Get the worker name.
     */
    public static function worker(): string;

    /**
     * Get the query column.
     */
    public static function queryColumn(): string;

    /**
     * Get the query column name.
     */
    public function getQueryColumn(AuthenticatableInterface $authenticatable, array $credentials): string;

    /**
     * Get the worker credential value.
     */
    public function getWorkerValue(array $credentials): ?string;

    /**
     * Find a worker account.
     */
    public function find(AuthenticatableInterface $authenticatable, array $credentials): ?AccountInterface;
}
