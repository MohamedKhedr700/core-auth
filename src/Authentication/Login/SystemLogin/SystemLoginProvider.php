<?php

namespace Raid\Core\AuthAuthentication\Login\SystemLogin;

use Raid\Core\AuthAuthentication\Contracts\AccountInterface;
use Raid\Core\AuthAuthentication\Contracts\Login\LoginProviderInterface;
use Raid\Core\AuthAuthentication\Login\LoginProvider;
use Raid\Core\AuthModels\Authentication\Enum\LoginType;

class SystemLoginProvider extends LoginProvider implements LoginProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public const LOGIN_TYPE = LoginType::SYSTEM;

    /**
     * {@inheritdoc}
     */
    public function checkLoginProviderRules(AccountInterface $user, array $credentials = []): bool
    {
        if (! $user->isMatchingPassword($credentials['password'] ?? '')) {
            $this->errors()->add('error', __('auth.not_found'));

            return false;
        }

        return true;
    }
}
