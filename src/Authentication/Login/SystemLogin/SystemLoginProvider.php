<?php

namespace Raid\Core\Auth\Authentication\Login\SystemLogin;

use Raid\Core\Auth\Authentication\Contracts\AccountInterface;
use Raid\Core\Auth\Authentication\Contracts\Login\LoginProviderInterface;
use Raid\Core\Auth\Authentication\Login\LoginProvider;
use Raid\Core\Auth\Models\Authentication\Enum\LoginType;

class SystemLoginProvider extends LoginProvider implements LoginProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public const LOGIN_TYPE = LoginType::SYSTEM;

    /**
     * {@inheritdoc}
     */
    public function checkLoginProviderRules(AccountInterface $account, array $credentials = []): bool
    {
        if (! $account->isMatchingPassword($credentials['password'] ?? '')) {
            $this->errors()->add('error', __('auth.not_found'));

            return false;
        }

        return true;
    }
}
