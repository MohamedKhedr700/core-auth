<?php

namespace Raid\Core\AuthAuthentication\Login;

use Raid\Core\Auth\Exceptions\Authentication\Login\LoginException;
use Raid\Core\AuthAuthentication\Contracts\AccountInterface;
use Raid\Core\AuthAuthentication\Contracts\Login\LoginProviderInterface;
use Raid\Core\Auth\Traits\Authentication\LoginProvider\WithAccount;
use Raid\Core\Auth\Traits\Authentication\LoginProvider\WithCredentials;
use Raid\Core\Auth\Traits\Authentication\LoginProvider\WithManager;
use Raid\Core\Auth\Traits\Authentication\LoginProvider\WithAccountable;
use Raid\Core\Auth\Traits\Authentication\LoginProvider\WithToken;
use Raid\Core\Model\Traits\Error\WithErrors;

abstract class LoginProvider implements LoginProviderInterface
{
    use WithAccount,
        WithAccountable,
        WithCredentials,
        WithErrors,
        WithManager,
        WithToken;

    /**
     * Login type.
     */
    public const LOGIN_TYPE = '';

    /**
     * Get a login type.
     */
    public static function loginType(): string
    {
        return static::LOGIN_TYPE;
    }

    /**
     * Attempt Login.
     */
    public function login(object $accountable, array $credentials): LoginProviderInterface
    {
        $this->setAccountable($accountable);

        $this->setCredentials($credentials);

        $loginManager = $this->setLoginManagerByType($credentials);

        if (! $loginManager) {
            $this->errors()->add('error', trans('auth.login_type_not_found'));

            return $this;
        }

        $account = $loginManager->fetchUser($accountable, $credentials);

        if (! $account) {
            $this->errors()->add('error', trans('auth.not_found'));

            return $this;
        }

        if (! $this->checkLoginProviderRules($account, $credentials)) {
            return $this;
        }

        $this->setAccount($account);

        if (! $this->checkActiveLoginRules($account)) {
            return $this;
        }

        $this->authenticateAccount($account);

        return $this;
    }

    /**
     * Login with given user.
     */
    public function loginByAccount(object $accountable, AccountInterface $account): LoginProviderInterface
    {
        $this->setAccountable($accountable);

        $this->setAccount($account);

        if ($this->checkActiveLoginRules($account)) {
            $this->authenticateAccount($this->account());
        }

        return $this;
    }

    /**
     * Check active user login based on a model.
     * Method `isLoginActive` found in a user model to control login check.
     * Base method in Accountable trait.
     */
    public function checkActiveLoginRules(AccountInterface $user): bool
    {
        try {
            $user->isLoginActive();
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
        $this->setToken($account->createUserToken());

        //        $this->attachDevice($account, device());

        //        authenticate_user($account);

        $this->authenticated = true;
    }

    /**
     * Check login provider rules after fetch user.
     */
    public function checkLoginProviderRules(AccountInterface $user, array $credentials = []): bool
    {
        return true;
    }
}
