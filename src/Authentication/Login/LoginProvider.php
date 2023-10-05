<?php

namespace Raid\Core\Auth\Authentication\Login;

use Raid\Core\Auth\Authentication\Contracts\AccountInterface;
use Raid\Core\Auth\Authentication\Contracts\Login\LoginProviderInterface;
use Raid\Core\Auth\Exceptions\Authentication\Login\LoginException;
use Raid\Core\Auth\Traits\Authentication\Login\WithAccount;
use Raid\Core\Auth\Traits\Authentication\Login\WithAccountable;
use Raid\Core\Auth\Traits\Authentication\Login\WithCredentials;
use Raid\Core\Auth\Traits\Authentication\Login\WithLoginManager;
use Raid\Core\Auth\Traits\Authentication\Login\WithToken;
use Raid\Core\Model\Traits\Error\WithErrors;

abstract class LoginProvider implements LoginProviderInterface
{
    use WithAccount,
        WithAccountable,
        WithCredentials,
        WithErrors,
        WithLoginManager,
        WithToken;

    /**
     * Login provider.
     */
    public const PROVIDER = '';

    /**
     * Get a login provider.
     */
    public static function provider(): string
    {
        return static::PROVIDER;
    }

    /**
     * Attempt Log in statically.
     */
    public static function attempt(string $accountable, array $credentials): LoginProviderInterface
    {
        return (new static())->login(new $accountable, $credentials);
    }

    /**
     * Attempt Log in statically with an account.
     */
    public static function attemptWithAccount(string $accountable, AccountInterface $account): LoginProviderInterface
    {
        return (new static())->loginWithAccount(new $accountable, $account);
    }

    /**
     * Attempt Log in.
     */
    public function login(object $accountable, array $credentials): LoginProviderInterface
    {
        $this->setAccountable($accountable);

        $this->setCredentials($credentials);

        $loginManager = $this->getLoginManagerByCredentials($credentials);

        if (! $loginManager) {
            $this->errors()->add('error', __('auth.login_type_not_found'));

            return $this;
        }

        $this->setLoginManager($loginManager);

        $account = $loginManager->fetchUser($accountable, $credentials);

        if (! $account) {
            $this->errors()->add('error', __('auth.not_found'));

            return $this;
        }

        if (! $this->checkLoginProviderRules($account, $credentials)) {
            return $this;
        }

        $this->setAccount($account);

        if (! $this->checkAccountAuthentication($account)) {
            return $this;
        }

        $this->authenticateAccount($account);

        return $this;
    }

    /**
     * Log in with a given account model.
     */
    public function loginAccount(object $accountable, AccountInterface $account): LoginProviderInterface
    {
        $this->setAccountable($accountable);

        $this->setAccount($account);

        if ($this->checkAccountAuthentication($account)) {
            $this->authenticateAccount($this->account());
        }

        return $this;
    }

    /**
     * Check active user login based on a model.
     * Method `isLoginActive` found in a user model to control login check.
     * Base method in Accountable trait.
     */
    public function checkAccountAuthentication(AccountInterface $account): bool
    {
        try {
            $account->isAuthenticated();
        } catch (LoginException $exception) {
            $this->errors()->add('error', $exception->getMessage());

            return false;
        }

        return true;
    }

    /**
     * Authenticate account.
     */
    public function authenticateAccount(AccountInterface $account): void
    {
        $this->setToken($account->createAccountToken());

        $this->authenticated = true;
    }

    /**
     * Check login provider rules after fetch user.
     */
    public function checkLoginProviderRules(AccountInterface $account, array $credentials = []): bool
    {
        return true;
    }
}
