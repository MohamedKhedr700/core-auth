<?php

namespace Raid\Core\Auth\Authentication\Contracts\Concerns;

interface WithRuleInterface
{
    /**
     * Get authentication rules.
     */
    public function rules(): array;

    /**
     * Run authentication rules.
     */
    public function runRules(array $rules): bool;
}
