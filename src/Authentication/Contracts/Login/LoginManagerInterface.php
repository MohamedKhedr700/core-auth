<?php

namespace Raid\Core\Auth\Authentication\Contracts\Login;

use Raid\Core\Auth\Authentication\Contracts\AccountInterface;

interface LoginManagerInterface
{
    /**
     * Apply login manager steps.
     */
    public function steps(): bool;
}
