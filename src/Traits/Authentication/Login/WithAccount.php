<?php

namespace Raid\Core\Auth\Traits\Authentication\Login;

use Raid\Core\Auth\Models\Authentication\Contracts\AccountInterface;

trait WithAccount
{
    /**
     * Account instance.
     */
    protected ?AccountInterface $account = null;

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
    public function found(): bool
    {
        return ! is_null($this->account);
    }

    /**
     * Determine if an account is authenticated.
     */
    public function authenticated(): bool
    {
        return $this->authenticated;
    }
}
