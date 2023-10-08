<?php

namespace Raid\Core\Auth\Traits\Authentication;

use Raid\Core\Auth\Authentication\Contracts\AuthWorkerInterface;
use Raid\Core\Auth\Models\Authentication\Contracts\AccountableInterface;
use Raid\Core\Auth\Models\Authentication\Contracts\AccountInterface;

trait WithWorker
{
    /**
     * Auth worker instance.
     */
    protected AuthWorkerInterface $authWorker;

    /**
     * {@inheritDoc}
     */
    public function workers(): array
    {
        return config('authentication.manager_workers.'.static::manager(), []);
    }

    /**
     * {@inheritDoc}
     */
    public function setAuthWorker(AuthWorkerInterface $authWorker): void
    {
        $this->authWorker = $authWorker;
    }

    /**
     * {@inheritDoc}
     */
    public function authWorker(): AuthWorkerInterface
    {
        return $this->authWorker;
    }

    /**
     * Get credential authentication worker.
     */
    private function getCredentialWorker(array $workers, array $credentials): ?AuthWorkerInterface
    {
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
    public function findWorkerAccount(array $workers, AccountableInterface $accountable, array $credentials): ?AccountInterface
    {
        $authWorker = $this->findWorker($workers, $credentials);

        return $authWorker ? $this->findAccount($authWorker, $accountable, $credentials) : null;
    }

    /**
     * Find worker.
     */
    public function findWorker(array $workers, array $credentials): ?AuthWorkerInterface
    {
        $authWorker = $this->getCredentialWorker($workers, $credentials);

        $authWorker ?
            $this->setAuthWorker($authWorker) :
            $this->errors()->add('error', __('auth.not_found_login_worker'));

        return $authWorker;
    }

    /**
     * Find account.
     */
    public function findAccount(AuthWorkerInterface $authWorker, AccountableInterface $accountable, array $credentials): ?AccountInterface
    {
        $account = $authWorker->find($accountable, $credentials);

        $account ?
            $this->setAccount($account) :
            $this->errors()->add('error', __('auth.not_found_account'));

        return $account;
    }
}
