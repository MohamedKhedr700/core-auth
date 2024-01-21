<?php

namespace Raid\Core\Auth\Authentication\Contracts\Concerns;

use Raid\Core\Auth\Models\Authentication\Contracts\AccountInterface;

interface WithTokenInterface
{
    /**
     * Create a token for account.
     */
    public function createToken(AccountInterface $account): void;

    /**
     * Get token response.
     */
    public function tokenResponse(): array;

    /**
     * Get user string token if presentable.
     */
    public function stringToken(): string;
}
