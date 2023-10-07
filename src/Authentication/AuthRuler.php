<?php

namespace Raid\Core\Auth\Authentication;

use Raid\Core\Auth\Authentication\Contracts\AuthManagerInterface;
use Raid\Core\Auth\Authentication\Contracts\AuthRulerInterface;

abstract class AuthRuler implements AuthRulerInterface
{
    /**
     * {@inheritdoc}
     */
    public function rule(AuthManagerInterface $loginManager): bool
    {
        return true;
    }
}
