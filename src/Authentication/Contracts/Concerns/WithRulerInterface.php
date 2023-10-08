<?php

namespace Raid\Core\Auth\Authentication\Contracts\Concerns;

interface WithRulerInterface
{
    /**
     * Get authentication rulers.
     */
    public function rules(): array;

    /**
     * Run all authentication rulers.
     */
    public function runRules(array $rules): bool;
}
