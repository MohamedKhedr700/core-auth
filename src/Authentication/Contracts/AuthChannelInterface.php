<?php

namespace Raid\Core\Auth\Authentication\Contracts;

use Raid\Core\Auth\Authentication\Contracts\Concerns\WithAuthenticatableInterface;
use Raid\Core\Auth\Authentication\Contracts\Concerns\WithAccountInterface;
use Raid\Core\Auth\Authentication\Contracts\Concerns\WithAuthenticationInterface;
use Raid\Core\Auth\Authentication\Contracts\Concerns\WithCredentialsInterface;
use Raid\Core\Auth\Authentication\Contracts\Concerns\WithErrorInterface;
use Raid\Core\Auth\Authentication\Contracts\Concerns\WithRuleInterface;
use Raid\Core\Auth\Authentication\Contracts\Concerns\WithStepInterface;
use Raid\Core\Auth\Authentication\Contracts\Concerns\WithTokenInterface;
use Raid\Core\Auth\Authentication\Contracts\Concerns\WithWorkerInterface;
use Raid\Core\Auth\Models\Authentication\Contracts\AccountableInterface;
use Raid\Core\Auth\Models\Authentication\Contracts\AccountInterface;

interface AuthChannelInterface extends WithAccountInterface, WithAuthenticatableInterface, WithAuthenticationInterface, WithCredentialsInterface, WithErrorInterface, WithRuleInterface, WithStepInterface, WithTokenInterface, WithWorkerInterface
{
    /**
     * Get an authentication channel.
     */
    public static function channel(): string;

    /**
     * Attempt to authenticate an authenticatable in statically.
     */
    public static function auth(string $authenticatable, array $credentials): AuthChannelInterface;

    /**
     * Attempt to authenticate an authenticatable in statically.
     */
    public static function authAccount(string $authenticatable, AccountInterface $account): AuthChannelInterface;

    /**
     * Authenticate an authenticatable with credentials.
     */
    public function authenticate(AuthenticatableInterface $authenticatable, array $credentials): AuthChannelInterface;

    /**
     * Authenticate an account.
     */
    public function authenticateAccount(AuthenticatableInterface $authenticatable, AccountInterface $account): AuthChannelInterface;
}
