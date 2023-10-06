<?php

namespace Raid\Core\Auth\Authentication\Contracts;

interface AccountableInterface
{
    /**
     * Find account.
     */
    public function findAccount();
}
