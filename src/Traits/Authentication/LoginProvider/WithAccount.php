<?php

namespace Raid\Core\Auth\Traits\Authentication\LoginProvider;

use Raid\Core\AuthAuthentication\Contracts\AccountInterface;

trait WithAccount
{
    /**
     * Account instance.
     */
    protected ?AccountInterface $account = null;

    /**
     * Authenticated account flag.
     */
    protected bool $authenticated = false;

    /**
     * Set account model if found.
     */
    public function setAccount(AccountInterface $account = null): void
    {
        $this->account = $account;
    }

    /**
     * Get an account model.
     */
    public function account(string $key = null, mixed $default = null): mixed
    {
        return $key ? ($this->account->{$key} ?? $default) : $this->account;
    }

    /**
     * Determine if an account is found.
     */
    public function accountFound(): bool
    {
        return ! empty($this->account);
    }

    /**
     * Determine if an account is authenticated.
     */
    public function isAuthenticated(): bool
    {
        return $this->authenticated;
    }
}
