<?php

namespace Raid\Core\Auth\Authentication\Login\Managers;

use Raid\Core\Auth\Authentication\Contracts\Login\LoginManagerInterface;
use Raid\Core\Auth\Authentication\Login\LoginManager;
use Raid\Core\Auth\Authentication\Login\Rulers\MatchingPasswordRuler;
use Raid\Core\Auth\Models\Authentication\Enum\LoginProvider as LoginProviderEnum;

class SystemLoginManager extends LoginManager implements LoginManagerInterface
{
    /**
     * {@inheritdoc}
     */
    public const MANAGER = LoginProviderEnum::SYSTEM;

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
