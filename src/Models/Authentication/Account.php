<?php

namespace Raid\Core\Auth\Models\Authentication;

use Illuminate\Contracts\Auth\Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Raid\Core\Auth\Models\Authentication\Contracts\AccountInterface;
use Raid\Core\Auth\Traits\Model\Deviceable;
use Raid\Core\Auth\Traits\Model\Relationable;
use Raid\Core\Auth\Traits\Model\Tokenable;
use Raid\Core\Auth\Traits\Model\WithAccount;
use Raid\Core\Auth\Traits\Model\WithAuthenticate;
use Raid\Core\Auth\Traits\Model\WithAuthIdentifier;
use Raid\Core\Auth\Traits\Model\WithPassword;
use Raid\Core\Model\Models\Contracts\ModelInterface;
use Raid\Core\Model\Models\Model;

abstract class Account extends Model implements AccountInterface, Authenticatable, ModelInterface
{
    use Deviceable;
    use HasApiTokens;
    use Relationable;
    use Tokenable;
    use WithAccount;
    use WithAuthenticate;
    use WithAuthIdentifier;
    use WithPassword;

    /**
     * {@inheritdoc}
     */
    protected string $filter;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [];

    /**
     * {@inheritdoc}
     */
    protected $appends = [];

    /**
     * {@inheritdoc}
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Account fillable attributes.
     */
    protected array $accountFillable = [
        'account_type', 'name', 'first_name', 'last_name', 'email',
        'country_code', 'phone', 'full_phone', 'password',
        'devices', 'is_disabled', 'is_verified', 'is_active',
        'last_login_at', 'last_login_ip',
    ];

    /**
     * {@inheritdoc}
     */
    protected array $additionalCast = [
        'last_login_at' => 'datetime',

    ];

    /**
     * {@inheritdoc}
     */
    public static function creatingObserve(ModelInterface $model): void
    {
        parent::creatingObserve($model);

        static::fillAccountType($model);
    }

    /**
     * Fill account type attribute.
     */
    public static function fillAccountType(AccountInterface $account): void
    {
        $account->fillAttribute('account_type', $account->accountType());
    }

    /**
     * Get the fillable attributes for the model.
     */
    public function getFillable(): array
    {
        return array_merge(parent::getFillable(), $this->accountFillable);
    }
}
