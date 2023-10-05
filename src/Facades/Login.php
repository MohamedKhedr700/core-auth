<?php

namespace Raid\Core\Auth\Facades;

use Raid\Core\Auth\Authentication\Contracts\Login\LoginProviderInterface;

/**
 * @mixin LoginProviderInterface
 */
class Login extends Facade
{
    /**
     * {@inheritdoc}
     */
    public const FACADE = 'Login';
}