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
    public static function attempt(string $accountable, array $credentials): static
    {
        return (new static())->login(new $accountable, $credentials);
    }

    /**
     * {@inheritdoc}
     */
    public static function attemptAccount(string $accountable, AccountInterface $account): static
    {
        return (new static())->loginAccount(new $accountable, $account);
    }

    /**
     * {@inheritdoc}
     */
    public function login(AccountableInterface $accountable, array $credentials): static
    {
        $this->setAccountable($accountable);

        $this->setCredentials($credentials);

        $account = $this->findWorkerAccount($accountable, $credentials);

        if ($this->errors()->any()) {
            return $this;
        }

        if (! $this->checkRulers($this->rulers())) {
            return $this;
        }

        if (method_exists($this, 'steps')) {
            $this->steps();

            return $this;
        }

        if (! $this->checkAuthentication($account)) {
            return $this;
        }

        $this->authenticate($account);

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function loginAccount(AccountableInterface $accountable, AccountInterface $account): static
    {
        $this->setAccountable($accountable);

        $this->setAccount($account);

        if (! $this->checkAuthentication($account)) {
            return $this;
        }

        $this->authenticate($account);

        return $this;
    }
}
