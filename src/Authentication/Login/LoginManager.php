<?php

namespace Raid\Core\Auth\Authentication\Login;

use Raid\Core\Auth\Authentication\Contracts\AccountableInterface;
use Raid\Core\Auth\Authentication\Contracts\AccountInterface;
use Raid\Core\Auth\Authentication\Contracts\Login\LoginManagerInterface;
use Raid\Core\Auth\Authentication\Contracts\Login\LoginProviderInterface;
use Raid\Core\Auth\Traits\Authentication\Login\WithAccount;
use Raid\Core\Auth\Traits\Authentication\Login\WithAccountable;
use Raid\Core\Auth\Traits\Authentication\Login\WithAuthentication;
use Raid\Core\Auth\Traits\Authentication\Login\WithCredentials;
use Raid\Core\Auth\Traits\Authentication\Login\WithRuler;
use Raid\Core\Auth\Traits\Authentication\Login\WithToken;
use Raid\Core\Auth\Traits\Authentication\Login\WithWorker;
use Raid\Core\Model\Traits\Error\WithErrors;

abstract class LoginManager implements LoginManagerInterface
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

        if (method_exists($this, 'steps')) {
            return $this;
        }

        $rulers = $this->rulers();

        if (! empty($rulers) && ! $this->checkRulers($rulers)) {
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

        $this->authenticate($account);

        return $this;
    }
}
