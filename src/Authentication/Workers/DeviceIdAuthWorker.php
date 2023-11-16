<?php

namespace Raid\Core\Auth\Authentication\Workers;

use Raid\Core\Auth\Authentication\AuthWorker;
use Raid\Core\Auth\Authentication\Contracts\AuthenticatableInterface;
use Raid\Core\Auth\Authentication\Contracts\AuthWorkerInterface;
use Raid\Core\Auth\Models\Authentication\Contracts\AccountableInterface;
use Raid\Core\Auth\Models\Authentication\Contracts\AccountInterface;
use Raid\Core\Auth\Models\Authentication\Enums\Worker;

class DeviceIdAuthWorker extends AuthWorker implements AuthWorkerInterface
{
    /**
     * {@inheritdoc}
     */
    public const WORKER = Worker::DEVICE_ID;

    /**
     * {@inheritdoc}
     */
    public function find(AuthenticatableInterface $authenticatable, array $credentials): ?AccountInterface
    {
        $device = parent::find($authenticatable, $credentials);

        return $device ? $authenticatable->update($device->accountId(), $credentials) : $authenticatable->create($credentials);
    }
}
