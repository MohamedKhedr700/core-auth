<?php

namespace Raid\Core\Auth\Traits\Authentication;

use Raid\Core\Auth\Authentication\Contracts\AuthenticatableInterface;
use Raid\Core\Auth\Authentication\Contracts\AuthWorkerInterface;
use Raid\Core\Auth\Models\Authentication\Contracts\AccountInterface;

trait WithWorkers
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
        return config('authentication.channel_workers.'.static::channel(), []);
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
     * Get a worker account.
     */
    public function getWorkerAccount(array $workers, AuthenticatableInterface $authenticatable, array $credentials): ?AccountInterface
    {
        $authWorker = $this->getWorker($workers, $credentials);

        return $authWorker ? $this->getAccount($authWorker, $authenticatable, $credentials) : null;
    }

    /**
     * Get credential authentication worker.
     */
    public function getWorker(array $workers, array $credentials): ?AuthWorkerInterface
    {
        $authWorker = $this->getCredentialWorker($workers, $credentials);

        $authWorker ?
            $this->setAuthWorker($authWorker) :
            $this->errors()->add('error', __('auth.not_found_login_worker'));

        return $authWorker;
    }

    /**
     * Get an account from worker.
     */
    public function getAccount(AuthWorkerInterface $authWorker, AuthenticatableInterface $authenticatable, array $credentials): ?AccountInterface
    {
        $account = $authWorker->find($authenticatable, $credentials);

        $account ?
            $this->setAccount($account) :
            $this->errors()->add('error', __('auth.not_found_account'));

        return $account;
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
     * Get worker column.
     */
    public function getWorkerColumn(): string
    {
        return $this->authWorker()->queryColumn() ?: $this->authWorker()->worker();
    }
}
