<?php

namespace Raid\Core\Auth\Authentication\Managers;

use Raid\Core\Auth\Authentication\Contracts\LoginManagerInterface;
use Raid\Core\Auth\Authentication\LoginManager;
use Raid\Core\Auth\Authentication\Rulers\MatchingPasswordRuler;
use Raid\Core\Auth\Models\Authentication\Enum\Manager;

class SystemLoginManager extends LoginManager implements LoginManagerInterface
{
    /**
     * {@inheritdoc}
     */
    public const MANAGER = Manager::SYSTEM;

    /**
     * {@inheritdoc}
     */
    public function rulers(): array
    {
        return [
            MatchingPasswordRuler::class,
        ];
    }
}
