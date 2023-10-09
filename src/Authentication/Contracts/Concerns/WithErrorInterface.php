<?php

namespace Raid\Core\Auth\Authentication\Contracts\Concerns;

use Raid\Core\Model\Errors\Errors;

interface WithErrorInterface
{
    /**
     * Get authentication errors.
     */
    public function errors(): Errors;
}
