<?php

namespace Raid\Core\Auth\Traits\Authentication\Login;

use Raid\Core\Auth\Authentication\Login\Contracts\LoginWorkerInterface;
use Raid\Core\Auth\Models\Authentication\Contracts\AccountableInterface;
use Raid\Core\Auth\Models\Authentication\Contracts\AccountInterface;

trait WithWorker
{
    /**
     * Login worker instance.
     */
    protected LoginWorkerInterface $loginWorker;

    /**
     * Get login manager workers.
     */
    public static function getLoginManagerWorkers(): array
    {
        return config('authentication.manager_workers.'.static::manager(), []);
    }

    /**
     * {@inheritDoc}
     */
    public function setLoginWorker(LoginWorkerInterface $loginWorker): void
    {
        $this->loginWorker = $loginWorker;
    }

    /**
     * {@inheritDoc}
     */
    public function loginWorker(): LoginWorkerInterface
    {
        return $this->loginWorker;
    }

    /**
     * Get credential login worker.
     */
    private function getCredentialWorker(array $credentials = []): ?LoginWorkerInterface
    {
        $workers = static::getLoginManagerWorkers();

        foreach ($workers as $worker) {
            if (! array_key_exists($worker::worker(), $credentials)) {
                continue;
            }

            return app($worker);
        }

        return null;
    }

    /**
     * Find a worker account.
     */
    public function findWorkerAccount(AccountableInterface $accountable, array $credentials): ?AccountInterface
    {
        $loginWorker = $this->findWorker($credentials);

        return $loginWorker ? $this->findAccount($loginWorker, $accountable, $credentials) : null;
    }

    /**
     * Find worker.
     */
    public function findWorker(array $credentials = []): ?LoginWorkerInterface
    {
        $loginWorker = $this->getCredentialWorker($credentials);

        $loginWorker ?
            $this->setLoginWorker($loginWorker) :
            $this->errors()->add('error', __('auth.not_found_login_worker'));

        return $loginWorker;
    }

    /**
     * Find account.
     */
    public function findAccount(LoginWorkerInterface $loginWorker, AccountableInterface $accountable, array $credentials): ?AccountInterface
    {
        $account = $loginWorker->find($accountable, $credentials);

        $account ?
            $this->setAccount($account) :
            $this->errors()->add('error', __('auth.not_found_account'));

        return $account;
    }
}
