<?php

namespace Raid\Core\Auth\Models\AccessToken;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Raid\Core\Model\Models\Model;
use Raid\Core\Model\Traits\Model\Attributable;

class PersonalAccessToken extends Model
{
    use Attributable;

    /**
     * {@inheritdoc}
     */
    protected $casts = [
        'abilities' => 'json',
        'last_used_at' => 'datetime',
    ];

    /**
     * {@inheritdoc}
     */
    protected $hidden = [
        'token',
    ];

    /**
     * Get the tokenable model that the access token belongs to.
     */
    public function tokenable(): MorphTo
    {
        return $this->morphTo('tokenable');
    }

    /**
     * Determine if the token has a given ability.
     */
    public function can(string $ability): bool
    {
        $abilities = $this->attribute('abilities', []);

        return in_array('*', $abilities) ||
            array_key_exists($ability, array_flip($abilities));
    }

    /**
     * Determine if the token is missing a given ability.
     */
    public function cant(string $ability): bool
    {
        return ! $this->can($ability);
    }

    /**
     * Find the token instance matching the given token.
     */
    public static function findToken(string $token): ?PersonalAccessToken
    {
        if (! str_contains($token, '|')) {
            return static::where('token', hash('sha256', $token))->first();
        }

        [$id, $token] = explode('|', $token, 2);

        if (! $instance = static::find($id)) {
            return null;
        }

        return hash_equals($instance->attribute('token'), hash('sha256', $token)) ? $instance : null;
    }
}
