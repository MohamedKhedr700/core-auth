<?php

namespace Raid\Core\Auth\Authentication;

use Raid\Core\Auth\Authentication\Contracts\AuthManagerInterface;
use Raid\Core\Auth\Authentication\Contracts\AuthStepInterface;

abstract class AuthStep implements AuthStepInterface
{
    /**
     * {@inheritdoc}
     */
    public function step(AuthManagerInterface $authManager): void
    {
    }
}