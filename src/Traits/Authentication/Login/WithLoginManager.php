<?php

namespace Raid\Core\Auth\Traits\Authentication\Login;

use Raid\Core\AuthAuthentication\Contracts\Login\LoginManagerInterface;

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
     * Get login manager by login type.
     */
    public function setLoginManagerByType(array $credentials = []): ?LoginManagerInterface
    {
        $loginManager = $this->getLoginManagerByType($credentials);

        if (! $loginManager) {
            return null;
        }

        $loginManager = new $loginManager();

        $this->setLoginManager($loginManager);

        return $loginManager;
    }

    /**
     * Get login manager by login type.
     */
    private function getLoginManagerByType(array $credentials = []): ?string
    {
        $managers = static::getLoginTypeManagers();

        foreach ($managers as $manager) {
            if (empty($credentials[$manager::getColumn()])) {
                continue;
            }

            return $manager;
        }

        return null;
    }
}
