<?php

namespace Raid\Core\Auth\Traits\Authentication;

use Raid\Core\Auth\Exceptions\Authentication\Login\LoginException;
use Raid\Core\Auth\Models\Authentication\Contracts\AccountInterface;

trait WithAuthentication
{
    /**
     * Authenticated account flag.
     */
    protected bool $authenticated = false;

    /**
     * {@inheritdoc}
     */
    public function authenticate(AccountInterface $account): void
    {
        $this->setToken($account->createAccountToken());

        $this->authenticated = true;
    }

    /**
     * {@inheritdoc}
     */
    public function checkAuthentication(AccountInterface $account): bool
    {
        try {
            $account->isAuthenticated();
        } catch (LoginException $exception) {
            $this->errors()->add('error', $exception->getMessage());

            return false;
        }

        $this->authenticated = true;

        return true;
    }
}
