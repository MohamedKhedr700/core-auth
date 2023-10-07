<?php

namespace Raid\Core\Auth\Authentication\Contracts\Concerns;

use Raid\Core\Auth\Models\Authentication\Contracts\AccountInterface;

interface WithTokenInterface
{
    /**
     * Create a token for account.
     */
    public function createToken(AccountInterface $account): void;
}
