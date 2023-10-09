<?php

namespace Raid\Core\Auth\Utilities;

class AuthUtility
{
    /**
     * Get the default authentication channel.
     */
    public static function getDefaultAuthChannel(): ?string
    {
        return config('authentication.default_channel');
    }
}