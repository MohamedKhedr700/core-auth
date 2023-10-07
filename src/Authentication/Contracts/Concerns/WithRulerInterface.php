<?php

namespace Raid\Core\Auth\Authentication\Contracts\Concerns;

interface WithRulerInterface
{
    /**
     * Get authentication rulers.
     */
    public function rulers(): array;

    /**
     * Run all authentication rulers.
     */
    public function runRulers(array $rulers): bool;
}
