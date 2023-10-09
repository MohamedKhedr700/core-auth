<?php

namespace Raid\Core\Auth\Authentication\Contracts;

use Raid\Core\Auth\Authentication\Contracts\Concerns\WithAccountableInterface;
use Raid\Core\Auth\Authentication\Contracts\Concerns\WithAccountInterface;
use Raid\Core\Auth\Authentication\Contracts\Concerns\WithAuthenticationInterface;
use Raid\Core\Auth\Authentication\Contracts\Concerns\WithCredentialsInterface;
use Raid\Core\Auth\Authentication\Contracts\Concerns\WithRuleInterface;
use Raid\Core\Auth\Authentication\Contracts\Concerns\WithStepInterface;
use Raid\Core\Auth\Authentication\Contracts\Concerns\WithTokenInterface;
use Raid\Core\Auth\Authentication\Contracts\Concerns\WithWorkerInterface;
use Raid\Core\Auth\Models\Authentication\Contracts\AccountableInterface;
use Raid\Core\Auth\Models\Authentication\Contracts\AccountInterface;

interface AuthChannelInterface extends WithAccountableInterface, WithAccountInterface, WithAuthenticationInterface, WithCredentialsInterface, WithRuleInterface, WithStepInterface, WithTokenInterface, WithWorkerInterface
{
    /**
     * Get a authentication channel.
     */
    public static function channel(): string;

    /**
     * Attempt to authenticate an accountable in statically.
     */
    public static function auth(string $accountable, array $credentials): AuthChannelInterface;

    /**
     * Attempt to authenticate an account in statically.
     */
    public static function authAccount(string $accountable, AccountInterface $account): AuthChannelInterface;

    /**
     * Authenticate an accountable.
     */
    public function authenticate(AccountableInterface $accountable, array $credentials): AuthChannelInterface;

    /**
     * Authenticate an account.
     */
    public function authenticateAccount(AccountableInterface $accountable, AccountInterface $account): AuthChannelInterface;
}
