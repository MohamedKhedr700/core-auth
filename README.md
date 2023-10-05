# Core Auth Package

This package is responsible for handling all auth models and login providers in the system.

## Installation

``` bash
composer require raid/core-auth
```

## Configuration

``` bash
php artisan core:publish-auth
```


## Usage

``` php
class UserController extends Controller
{
    /**
     * Invoke the controller method.
     */
    public function __invoke(Request $request, SystemLoginProvider $systemLoginProvider): JsonResponse
    {
        $credentials = $request->only([
            'email', 'phone', 'emailOrPhone', 'password',
        ]);

        $loginProvider = $systemLoginProvider->login(new User(), $credentials);

        // or using static call
        $loginProvider = SystemLoginProvider::attempt(User::class, $credentials);

        // or using accountable static call
        $loginProvider = User::login($credentials);

        return response()->json([
            'provider' => $loginProvider->provider(),
            'token' => $loginProvider->stringToken(),
            'resource' => $loginProvider->account(),
        ]);
    }
}
```

# How to work this

Let's start with our accountable class ex:`User` model,
to create our model class, we can use this command.

``` bash
php artisan core:make-auth-model User
```

Here is the model class.

``` php
<?php

namespace App\Models;

use Raid\Core\Auth\Models\Authentication\Account;

class User extends Account
{
    /**
     * {@inheritdoc}
     */
    protected $fillable = [];
}
```

The `Model` class must extend the package `Account` class.

Now the `User` model class is ready to use as an accountable model.

<br>

Great, now we have to take a look at our login providers and managers in `config/authentication.php` file.

``` php
'provider_managers' => [
    DeviceLoginProvider::PROVIDER => [
        DeviceIdLoginManager::class,
    ],
    SystemLoginProvider::PROVIDER => [
        EmailLoginManager::class,
        PhoneLoginManager::class,
        EmailOrPhoneLoginManager::class,
    ],
],
```

The `provider_managers` array is responsible for defining the login providers and their managers.
and we can add our custom login providers and managers to this array.

The `DeviceLoginProvider` is responsible for handling the device login process.

The `SystemLoginProvider` is responsible for handling the system login process.

Each login provider has its own login managers, and each login manager has its own login method.

<br>

When we call the `SystemLoginProvider` login method,
it will call the matched login manager with the given credentials.

We can add a custom login manager to use it with the `SystemLoginProvider` login provider or any other new login provider.

Let's create a new login manager class.

``` bash
php artisan core:make-auth-manager UsernameLoginManager
```

``` php
<?php

namespace App\Http\Authentication\Managers;

use Raid\Core\Auth\Authentication\Contracts\Login\LoginManagerInterface;
use Raid\Core\Auth\Authentication\Login\LoginManager;

class UsernameLoginManager extends LoginManager implements LoginManagerInterface
{
    /**
     * {@inheritdoc}
     */
    public const MANAGER = '';
}

```

The `LoginManager` class must extend the package `LoginManager` class.

The `MANAGER` constant is responsible for defining the login manager name.

The `MANAGER` constant is used to match the login manager with the given credentials.

The `MANAGER` constant is used to define the accountable query column,
you can override using same key for credentials and query by defining the `QUERY_COLUMN` constant.

``` php
<?php

namespace App\Http\Authentication\Managers;

use Raid\Core\Auth\Authentication\Contracts\Login\LoginManagerInterface;
use Raid\Core\Auth\Authentication\Login\LoginManager;

class UsernameLoginManager extends LoginManager implements LoginManagerInterface
{
    /**
     * {@inheritdoc}
     */
    public const MANAGER = 'username';
    
    /**
     * {@inheritdoc}
     */
    public const QUERY_COLUMN = 'user_name';
}
```

The `QUERY_COLUMN` constant is used to define the accountable query column.

<br>

Now let's go back to our `UserController` class.

``` php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Raid\Core\Auth\Authentication\Login\SystemLogin\SystemLoginProvider;

class UserController extends Controller
{
    /**
     * Invoke the controller method.
     */
    public function __invoke(Request $request, SystemLoginProvider $systemLoginProvider): JsonResponse
    {
        $credentials = $request->only([
            'username', 'password',
        ]);

        $loginProvider = $systemLoginProvider->login(new User(), $credentials);

        return response()->json([
            'provider' => $loginProvider->provider(),
            'token' => $loginProvider->stringToken(),
            'resource' => $loginProvider->account(),
        ]);
    }
}
```

The `SystemLoginProvider` login method accepts two parameters.

The first parameter is the accountable class instance.

The second parameter is the credentials array.

The `SystemLoginProvider` login method returns the `LoginProvider` class instance.

The `LoginProvider` class instance uses the credentials array to match with login manager.

The `LoginManager` class instance used to query the accountable class to find the matched account.

The `LoginProvider` class apply its own login rules after finding the account.

Then, you apply authentication rules on the account itself using the method `isAuthenticated`.

``` php
<?php

namespace App\Models;

use Raid\Core\Auth\Models\Authentication\Account;

class User extends Account
{
    /**
     * {@inheritdoc}
     */
    protected $fillable = [
        'user_name',
        'email',
        'password',
    ];
    
    /**
     * {@inheritDoc}
     */
    protected $hidden = [
        'password',
    ];
    
    /**
     * Check if an account is active to log in and authenticated.
     * Throw login exceptions if failed to log in.
     */
    public function isAuthenticated(): void
    {
        if ($this->isBanned()) {
            throw new Exception(__('auth.user_is_banned.'));
        }
    }
    
        /**
     * Determine if user is banned.
     */
    public function isBanned(): bool
    {
        return $this->attribute('is_banned', false);
    }
}
```

The `isAuthenticated` method is responsible for checking if the account is authenticated or not.

The `isAuthenticated` method should throw an exception if the account is not authenticated.

The `Exception` will not be thrown in the system,
but the errors can be called with the `errors` method in the `LoginProvider` class instance.

The `errors` method will return an `Raid\Core\Model\Errors\Errors` class instance.


``` php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Raid\Core\Auth\Authentication\Login\SystemLogin\SystemLoginProvider;

class UserController extends Controller
{
    /**
     * Invoke the controller method.
     */
    public function __invoke(Request $request, SystemLoginProvider $systemLoginProvider): JsonResponse
    {
        $credentials = $request->only([
            'username', 'password',
        ]);

        $loginProvider = $systemLoginProvider->login(new User(), $credentials);

        return response()->json([
            'provider' => $loginProvider->provider(),
            'token' => $loginProvider->getStringToken(),
            'resource' => $loginProvider->account(),
            'errors' => $loginProvider->errors()->toArray(),
        ]);
    }
}
```

<br>

You can work with the `errors` method as a `Illuminate\Support\MessageBag` class instance,
and you can get the errors with many ways.

``` php
class UserController extends Controller
{
    /**
     * Invoke the controller method.
     */
    public function __invoke(Request $request, SystemLoginProvider $systemLoginProvider): JsonResponse
    {
        $credentials = $request->only([
            'username', 'password',
        ]);

        $loginProvider = $systemLoginProvider->login(new User(), $credentials);

        $errorsAsArray = $loginProvider->errors()->toArray();
        $errorsAsJson = $loginProvider->errors()->toJson();
        
        $allErrors = $loginProvider->errors()->all();
        
        $errorsByKey = $loginProvider->errors()->get('error');

        $firstError = $loginProvider->errors()->first();
        $firstErrorByKey = $loginProvider->errors()->first('error');

        $lastError = $loginProvider->errors()->last();
        $lastErrorByKey = $loginProvider->errors()->last('error');
    }
```

The `errors` method returns an `Raid\Core\Model\Errors\Errors` class instance.

The `toArray` method returns an array of errors.

The `toJson` method returns a json string of errors.

The `all` method returns all errors as an array.

The `get` method returns an array of errors for the given key.

The `first` method returns the first error, or the first error for the given key.

The `last` method returns the last error, or the last error for the given key.

<br>

You can work with `errors` method again in the `LoginProvider` class.

You can create your own login provider using this command.

``` bash
php artisan core:make-auth-provider CustomLoginProvider
```

``` php
<?php

namespace App\Http\Authentication\Providers;

use Raid\Core\Auth\Authentication\Contracts\Login\LoginProviderInterface;
use Raid\Core\Auth\Authentication\Login\LoginProvider;

class OtpLoginProvider extends LoginProvider implements LoginProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public const PROVIDER = '';
}
```

The `LoginProvider` class must extend the package `LoginProvider` class.

The `PROVIDER` constant is responsible for defining the login provider name.

The login provider is the main class that handles the login process, and it defines his own login rules.

``` php
<?php

namespace App\Http\Authentication\Providers;

use Raid\Core\Auth\Authentication\Contracts\Login\LoginProviderInterface;
use Raid\Core\Auth\Authentication\Login\LoginProvider;

class OtpLoginProvider extends LoginProvider implements LoginProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public const PROVIDER = 'otp';

    /**
     * Check login provider rules after find user.
     */
    public function checkLoginRules(AccountInterface $account, array $credentials = []): bool
    {
        if (! $account->verifiedPhone()) {
            $this->errors()->add('error', __('Your phone number is not verified.'));

            return false;
        }

        return parent::checkLoginRules($account, $credentials);
    }
}
```

The `checkLoginRules` method is responsible for checking the login provider rules.

The `checkLoginRules` method should return `true` if the login provider rules are passed,

and should return `false` if the login provider rules are not passed.

The `checkLoginRules` method should add errors to the `errors` method if the login provider rules are not passed.

<br>

You can define a default login provider and use the `` facade to process the login.

In `config/authentication.php` file.

``` php 
'default_provider' => \App\Http\Authentication\Providers\OtpLoginProvider::class,
```

``` php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Raid\Core\Auth\Facades\Authentication;

class UserController extends Controller
{
    /**
     * Invoke the controller method.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $credentials = $request->only([
            'username', 'password',
        ]);

        $loginProvider = Authentication::login(new User(), $credentials);

        return response()->json([
            'provider' => $loginProvider->provider(),
            'token' => $loginProvider->getStringToken(),
            'resource' => $loginProvider->account(),
        ]);
    }
}
```

The `Authentication` facade is responsible for handling the login process.

The `Authentication` facade uses the `default_provider` key in `config/authentication.php` file to process the login.

<br>

And that's it.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Credits

- **[Mohamed Khedr](https://github.com/MohamedKhedr700)**

## Security

If you discover any security-related issues, please email
instead of using the issue tracker.

## About Raid

Raid is a PHP framework created by **[Mohamed Khedr](https://github.com/MohamedKhedr700)**,
and it is maintained by **[Mohamed Khedr](https://github.com/MohamedKhedr700)**.

## Support Raid

Raid is an MIT-licensed open-source project. It's an independent project with its ongoing development made possible.

