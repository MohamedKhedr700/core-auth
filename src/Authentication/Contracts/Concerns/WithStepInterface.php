<?php

namespace Raid\Core\Auth\Authentication\Contracts\Concerns;

interface WithStepInterface
{
    /**
     * Get authentication steps.
     */
    public function steps(): array;

    /**
     * Run authentication steps.
     */
    public function runSteps(array $rules): bool;
}
