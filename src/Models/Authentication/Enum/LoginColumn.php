<?php

namespace Raid\Core\AuthModels\Authentication\Enum;

use Raid\Core\Enum\Models\Enum;

class LoginColumn extends Enum
{
    public const DEVICE_ID = 'deviceId';

    public const EMAIL = 'email';

    public const PHONE = 'phone';

    public const EMAIL_OR_PHONE = 'emailOrPhone';
}
