<?php

namespace Raid\Core\Auth\Authentication\Contracts\Concerns;

use Raid\Core\Auth\Models\Authentication\Contracts\AccountInterface;

interface WithAuthenticationInterface
{
    /**
     * Check account authentication.
     */
    public function checkAuthentication(AccountInterface $account): bool;
}
