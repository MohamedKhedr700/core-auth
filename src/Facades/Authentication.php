<?php

namespace Raid\Core\Auth\Facades;

use Raid\Core\Auth\Authentication\Contracts\AuthChannelInterface;

/**
 * @mixin AuthChannelInterface
 */
class Authentication extends Facade
{
    /**
     * {@inheritdoc}
     */
    public const FACADE = 'Authentication';
}
