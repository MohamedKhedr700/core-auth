<?php

namespace Raid\Core\Auth\Models\AccessToken;

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
     * {@inheritDoc}
     */
    public static function boot(): void
    {
        parent::boot();

        static::creating(function ($model) {
            //
        });
    }
}
