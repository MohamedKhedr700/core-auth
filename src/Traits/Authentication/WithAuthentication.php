<?php

namespace Raid\Core\Auth\Traits\Authentication;

use Raid\Core\Auth\Exceptions\Authentication\Login\AuthenticationException;
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
    public function checkAuthentication(AccountInterface $account): bool
    {
        try {
            $account->isAuthenticated();
        } catch (AuthenticationException $exception) {
            $this->errors()->add('error', $exception->getMessage());

            return false;
        }

        $this->authenticated = true;

        return true;
    }
}
