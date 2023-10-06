<?php

namespace Raid\Core\Auth\Authentication\Login\Contracts\Concerns;

interface WithRulerInterface
{
    /**
     * Get login rulers.
     */
    public function rulers(): array;

    /**
     * Check login rulers.
     */
    public function checkRulers(array $rulers): bool;
}
