<?php

namespace Raid\Core\Auth\Authentication\Login;

use Exception;
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
     * {@inheritdoc}
     */
    public static function provider(): string
    {
        return static::PROVIDER;
    }

    /**
     * {@inheritdoc}
     */
    public static function attempt(string $accountable, array $credentials): LoginProviderInterface
    {
        return (new static())->login(new $accountable, $credentials);
    }

    /**
     * {@inheritdoc}
     */
    public static function attemptAccount(string $accountable, AccountInterface $account): LoginProviderInterface
    {
        return (new static())->loginAccount(new $accountable, $account);
    }

    /**
     * {@inheritdoc}
     */
    public function login(object $accountable, array $credentials): LoginProviderInterface
    {
        $this->setAccountable($accountable);

        $this->setCredentials($credentials);

        $loginManager = $this->getCredentialsManager($credentials);

        if (! $loginManager) {
            $this->errors()->add('error', __('auth.login_manager_not_found'));

            return $this;
        }

        $this->setLoginManager($loginManager);

        $account = $loginManager->findAccount($accountable, $credentials);

        if (! $account) {
            $this->errors()->add('error', __('auth.not_found'));

            return $this;
        }

        if (! $this->checkLoginRules($account, $credentials)) {
            return $this;
        }

        $this->setAccount($account);

        $this->authenticateAccount($account);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function loginAccount(object $accountable, AccountInterface $account): LoginProviderInterface
    {
        $this->setAccountable($accountable);

        $this->setAccount($account);

        $this->authenticateAccount($account);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function checkLoginRules(AccountInterface $account, array $credentials = []): bool
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function authenticateAccount(AccountInterface $account): void
    {
        if (! $this->checkAccountAuthentication($account)) {
            return;
        }

        $this->setToken($account->createAccountToken());

        $this->authenticated = true;
    }

    /**
     * {@inheritdoc}
     */
    public function checkAccountAuthentication(AccountInterface $account): bool
    {
        try {
            $account->isAuthenticated();
        } catch (LoginException|Exception $exception) {
            $this->errors()->add('error', $exception->getMessage());

            return false;
        }

        return true;
    }
}
