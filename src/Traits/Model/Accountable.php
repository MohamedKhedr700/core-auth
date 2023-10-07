<?php

namespace Raid\Core\Auth\Traits\Model;

use Raid\Core\Auth\Models\Authentication\Contracts\AccountInterface;

trait Accountable
{
    /**
     * Find an account by key and value.
     */
    public function findAccount(string $key, mixed $value): ?AccountInterface
    {
        return $this->where($key, $value)->first();
    }
}
