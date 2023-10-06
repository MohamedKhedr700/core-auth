<?php

namespace Raid\Core\Auth\Facades;

use Raid\Core\Auth\Authentication\Login\Contracts\LoginManagerInterface;

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
