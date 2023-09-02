<?php

namespace Raid\Core\Auth\Traits\Authentication\Login;

use Raid\Core\Auth\Authentication\Contracts\Login\LoginManagerInterface;

trait WithLoginManager
{
    /**
     * Login manager instance.
     */
    protected LoginManagerInterface $loginManager;

    /**
     * Get login type managers.
     */
    public static function getLoginTypeManagers(): array
    {
        return config('authentication.login_managers.'.static::loginType(), []);
    }

    /**
     * {@inheritDoc}
     */
    public function setLoginManager(LoginManagerInterface $loginManager): void
    {
        $this->loginManager = $loginManager;
    }

    /**
     * {@inheritDoc}
     */
    public function loginManager(): LoginManagerInterface
    {
        return $this->loginManager;
    }

    /**
     * Get login manager by credentials.
     */
    private function getLoginManagerByCredentials(array $credentials = []): ?LoginManagerInterface
    {
        $managers = static::getLoginTypeManagers();

        foreach ($managers as $manager) {
            if (empty($credentials[$manager::column()])) {
                continue;
            }

            return new $manager;
        }

        return null;
    }
}
