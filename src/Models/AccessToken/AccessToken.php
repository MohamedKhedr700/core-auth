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
        parent::creatingObserve($model);
    }

    /**
     * Get request current token if presented.
     */
    public static function currentToken(): ?PersonalAccessToken
    {
        $token = request()->bearerToken();

        return $token ? static::findToken($token) : null;
    }
}
