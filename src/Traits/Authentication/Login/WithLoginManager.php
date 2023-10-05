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
     * Get login provider managers.
     */
    public static function getLoginProviderManagers(): array
    {
        return config('authentication.provider_managers.'.static::provider(), []);
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
     * Get credentials login manager.
     */
    private function getCredentialsManager(array $credentials = []): ?LoginManagerInterface
    {
        $managers = static::getLoginProviderManagers();

        foreach ($managers as $manager) {
            if (! array_key_exists($manager::manager(), $credentials)) {
                continue;
            }

            return new $manager;
        }

        return null;
    }
}
