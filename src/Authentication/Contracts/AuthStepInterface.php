<?php

namespace Raid\Core\Auth\Authentication\Contracts;

interface AuthStepInterface
{
    /**
     * Run an authentication step.
     */
    public function step(AuthChannelInterface $authChannel): void;
}
