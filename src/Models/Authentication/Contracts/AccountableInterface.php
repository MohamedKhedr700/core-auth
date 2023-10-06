<?php

namespace Raid\Core\Auth\Models\Authentication\Contracts;

interface AccountableInterface
{
    /**
     * Find an account by key and value.
     */
    public function findAccount(string $key, mixed $value): ?AccountInterface;
}
