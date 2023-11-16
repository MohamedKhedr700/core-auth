<?php

namespace Raid\Core\Auth\Authentication;

use Raid\Core\Auth\Authentication\Contracts\AuthChannelInterface;
use Raid\Core\Auth\Authentication\Contracts\AuthStepInterface;

abstract class AuthStep implements AuthStepInterface
{
    /**
     * {@inheritdoc}
     */
    public function step(AuthChannelInterface $authChannel): void
    {
    }
}
