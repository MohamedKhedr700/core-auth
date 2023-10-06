<?php

namespace Raid\Core\Auth\Authentication\Login\Managers;

use Raid\Core\Auth\Authentication\Login\Contracts\LoginManagerInterface;
use Raid\Core\Auth\Authentication\Login\LoginManager;
use Raid\Core\Auth\Authentication\Login\Rulers\MatchingPasswordRuler;
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
