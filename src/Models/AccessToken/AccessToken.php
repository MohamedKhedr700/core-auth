<?php

namespace Raid\Core\Auth\Models\AccessToken;

use Raid\Core\Model\Models\Contracts\ModelInterface;

class AccessToken extends PersonalAccessToken
{
    /**
     * {@inheritdoc}
     */
    protected $table = 'personal_access_tokens';

    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'name',
        'token',
        'abilities',
    ];

    /**
     * {@inheritdoc}
     */
    public static function creatingObserve(ModelInterface $model): void
    {
    }
}
