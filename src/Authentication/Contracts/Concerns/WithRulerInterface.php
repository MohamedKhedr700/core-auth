<?php

namespace Raid\Core\Auth\Authentication\Contracts\Concerns;

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
