<?php

namespace Raid\Core\Auth\Traits\Authentication\Accountable;

use Raid\Core\Auth\Models\Authentication\Contracts\AccountInterface;

trait Accountable
{
    /**
     * {@inheritDoc}
     */
    public function findAccount(string $key, mixed $value): ?AccountInterface
    {
        return $this->where($key, $value)->first();
    }
}
