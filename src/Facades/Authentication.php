<?php

namespace Raid\Core\Auth\Facades;

use Raid\Core\Auth\Authentication\Contracts\AuthManagerInterface;

/**
 * @mixin AuthManagerInterface
 */
class Authentication extends Facade
{
    /**
     * {@inheritdoc}
     */
    public const FACADE = 'Authentication';
}
