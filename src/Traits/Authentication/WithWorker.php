<?php

namespace Raid\Core\Auth\Traits\Authentication;

use Raid\Core\Auth\Authentication\Contracts\AuthWorkerInterface;
use Raid\Core\Auth\Models\Authentication\Contracts\AccountableInterface;
use Raid\Core\Auth\Models\Authentication\Contracts\AccountInterface;

trait WithWorker
{
    /**
     * Login worker instance.
     */
    protected AuthWorkerInterface $loginWorker;

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
    public function setLoginWorker(AuthWorkerInterface $loginWorker): void
    {
        $this->loginWorker = $loginWorker;
    }

    /**
     * {@inheritDoc}
     */
    public function loginWorker(): AuthWorkerInterface
    {
        return $this->loginWorker;
    }

    /**
     * Get credential login worker.
     */
    private function getCredentialWorker(array $credentials = []): ?AuthWorkerInterface
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
    public function findWorker(array $credentials = []): ?AuthWorkerInterface
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
    public function findAccount(AuthWorkerInterface $loginWorker, AccountableInterface $accountable, array $credentials): ?AccountInterface
    {
        $account = $loginWorker->find($accountable, $credentials);

        $account ?
            $this->setAccount($account) :
            $this->errors()->add('error', __('auth.not_found_account'));

        return $account;
    }
}
