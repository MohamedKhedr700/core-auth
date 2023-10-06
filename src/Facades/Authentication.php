<?php

namespace Raid\Core\Auth\Facades;

use Raid\Core\Auth\Authentication\Contracts\Login\LoginManagerInterface;

/**
 * @mixin LoginManagerInterface
 */
class Authentication extends Facade
{
    /**
     * {@inheritdoc}
     */
    public const FACADE = 'Authentication';
}
