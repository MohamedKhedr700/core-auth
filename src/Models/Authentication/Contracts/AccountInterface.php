<?php

namespace Raid\Core\Auth\Models\Authentication\Contracts;

interface AccountInterface
{
    /**
     * Get an account type statically.
     */
    public static function accountType(): string;

    /**
     * Get account ID.
     */
    public function accountId(): string;
}
