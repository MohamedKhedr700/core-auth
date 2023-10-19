<?php

namespace Raid\Core\Auth\Authentication;

use Raid\Core\Auth\Authentication\Contracts\AuthChannelInterface;
use Raid\Core\Auth\Authentication\Contracts\AuthenticatableInterface;
use Raid\Core\Auth\Models\Authentication\Contracts\AccountInterface;
use Raid\Core\Auth\Traits\Authentication\WithAccount;
use Raid\Core\Auth\Traits\Authentication\WithAuthenticatable;
use Raid\Core\Auth\Traits\Authentication\WithAuthentication;
use Raid\Core\Auth\Traits\Authentication\WithCredentials;
use Raid\Core\Auth\Traits\Authentication\WithRules;
use Raid\Core\Auth\Traits\Authentication\WithSteps;
use Raid\Core\Auth\Traits\Authentication\WithToken;
use Raid\Core\Auth\Traits\Authentication\WithWorkers;
use Raid\Core\Model\Traits\Error\WithErrors;

abstract class AuthChannel implements AuthChannelInterface
{
    use WithAccount;
    use WithAuthenticatable;
    use WithAuthentication;
    use WithCredentials;
    use WithErrors;
    use WithRules;
    use WithSteps;
    use WithToken;
    use WithWorkers;

    /**
     * Authentication channel.
     */
    public const CHANNEL = '';

    /**
     * {@inheritdoc}
     */
    public static function channel(): string
    {
        return static::CHANNEL;
    }

    /**
     * {@inheritdoc}
     */
    public static function auth(string $authenticatable, array $credentials): AuthChannelInterface
    {
        return (new static())->authenticate(app($authenticatable), $credentials);
    }

    /**
     * {@inheritdoc}
     */
    public static function authAccount(string $authenticatable, AccountInterface $account): AuthChannelInterface
    {
        return (new static())->authenticateAccount(app($authenticatable), $account);
    }

    /**
     * {@inheritdoc}
     */
    public function authenticate(AuthenticatableInterface $authenticatable, array $credentials): AuthChannelInterface
    {
        $this->setAuthenticatable($authenticatable);

        $this->setCredentials($credentials);

        $account = $this->getWorkerAccount($this->workers(), $authenticatable, $credentials);

        if ($this->errors()->any()) {
            return $this;
        }

        if (! $this->runRules($this->rules())) {
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
    public function authenticateAccount(AuthenticatableInterface $authenticatable, AccountInterface $account): AuthChannelInterface
    {
        $this->setAuthenticatable($authenticatable);

        $this->setAccount($account);

        if (! $this->checkAuthentication($account)) {
            return $this;
        }

        $this->createToken($account);

        return $this;
    }
}
