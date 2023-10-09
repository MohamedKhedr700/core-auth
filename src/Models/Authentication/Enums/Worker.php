<?php

namespace Raid\Core\Auth\Models\Authentication\Enums;

use Raid\Core\Enum\Enums\Enum;

class Worker extends Enum
{
    public const DEVICE_ID = 'deviceId';

    public const EMAIL = 'email';

    public const USERNAME = 'username';

    public const PHONE = 'phone';

    public const EMAIL_OR_PHONE = 'emailOrPhone';
}
