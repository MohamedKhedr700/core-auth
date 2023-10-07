<?php

namespace Raid\Core\Auth\Authentication;

use Raid\Core\Auth\Authentication\Contracts\AuthManagerInterface;
use Raid\Core\Auth\Models\Authentication\Contracts\AccountableInterface;
use Raid\Core\Auth\Models\Authentication\Contracts\AccountInterface;
use Raid\Core\Auth\Traits\Authentication\WithAccount;
use Raid\Core\Auth\Traits\Authentication\WithAccountable;
use Raid\Core\Auth\Traits\Authentication\WithAuthentication;
use Raid\Core\Auth\Traits\Authentication\WithCredentials;
use Raid\Core\Auth\Traits\Authentication\WithRuler;
use Raid\Core\Auth\Traits\Authentication\WithSteps;
use Raid\Core\Auth\Traits\Authentication\WithToken;
use Raid\Core\Auth\Traits\Authentication\WithWorker;
use Raid\Core\Model\Traits\Error\WithErrors;

abstract class AuthManager implements AuthManagerInterface
{
    use WithAccount;
    use WithAccountable;
    use WithAuthentication;
    use WithCredentials;
    use WithErrors;
    use WithRuler;
    use WithSteps;
    use WithToken;
    use WithWorker;

    /**
     * Login manager.
     */
    public const MANAGER = '';

    /**
     * {@inheritdoc}
     */
    public static function manager(): string
    {
        return static::MANAGER;
    }

    /**
     * {@inheritdoc}
     */
    public static function auth(string $accountable, array $credentials): AuthManagerInterface
    {
        return (new static())->authenticate(new $accountable, $credentials);
    }

    /**
     * {@inheritdoc}
     */
    public static function authAccount(string $accountable, AccountInterface $account): AuthManagerInterface
    {
        return (new static())->authenticateAccount(new $accountable, $account);
    }

    /**
     * {@inheritdoc}
     */
    public function authenticate(AccountableInterface $accountable, array $credentials): AuthManagerInterface
    {
        $this->setAccountable($accountable);

        $this->setCredentials($credentials);

        $account = $this->findWorkerAccount($accountable, $credentials);

        if ($this->errors()->any()) {
            return $this;
        }

        if (! $this->runRulers($this->rulers())) {
            return $this;
        }

        if ($this->runSteps($this->steps())) {
            return $this;
        }

        if (! $this->checkAuthentication($account)) {
            return $this;
        }

        $this->createToken($account);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function authenticateAccount(AccountableInterface $accountable, AccountInterface $account): AuthManagerInterface
    {
        $this->setAccountable($accountable);

        $this->setAccount($account);

        if (! $this->checkAuthentication($account)) {
            return $this;
        }

        $this->createToken($account);

        return $this;
    }
}
