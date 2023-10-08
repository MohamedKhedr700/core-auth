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
class AuthController extends Controller
{
    /**
     * Invoke the controller method.
     */
    public function __invoke(Request $request, SystemAuthManager $authManager): JsonResponse
    {
        $credentials = $request->only([
            'email', 'phone', 'username', 'password',
        ]);

        $authManager = $authManager->authenticate(new User(), $credentials);

        // or using static call
        $authManager = SystemAuthManager::auth(User::class, $credentials);

        // or using accountable static call
        $authManager = User::authenticate($credentials);

        // or using facade
        $authManager = Authentication::authenticate(new User(), $credentials);

        return response()->json([
            'manager' => $authManager->manager(),
            'token' => $authManager->stringToken(),
            'errors' => $authManager->errors()->toArray(),
            'resource' => $authManager->account(),
        ]);
    }
}
```

# How to work this

The authentication process is divided into two parts.

The first part is the accountable class, and the second part is the auth manager.

The `Accountable` class is the class that will be authenticated, and it must implement `AccountableInterface` interface.

The `AuthManager` class is the class that will handle the authentication process,
and it must implement `AuthManagerInterface` interface.

The `AuthManager` uses the `Accountable` class to query the account using the given credentials.

The `Accountable` class must define `findAccount` method to query the account,
and return an instance of `AccountInterface` interface.

The `Accountable` class can be the same or different from the `AccountInterface` class,
but it must query the account and return an instance of `AccountInterface` interface.

Let's start with our `AccountInterface` class ex:`User` model,
we can use this command to create an account model.

``` bash
php artisan core:make-auth-model User
```
``` php
<?php

namespace App\Models;

use Raid\Core\Auth\Models\Authentication\Contracts\AccountInterface;
use Raid\Core\Auth\Models\Authentication\Account;

class User extends Account implements AccountInterface
{
    /**
     * {@inheritdoc}
     */
    protected $fillable = [];
}
```

The `Model` class must implement `AccountInterface` interface.

The `Model` class must extend `Account` class.

Now the `User` model class is ready to use as an account model.

Let's configure our `Model` class to work as `Accountable` class also.

``` php
<?php

namespace App\Models;

use Raid\Core\Auth\Models\Authentication\Contracts\AccountableInterface;
use Raid\Core\Auth\Models\Authentication\Contracts\AccountInterface;
use Raid\Core\Auth\Models\Authentication\Account;
use Raid\Core\Auth\Traits\Model\Accountable;

class User extends Account implements AccountInterface, AccountableInterface
{
    use Accountable;

    /**
     * {@inheritdoc}
     */
    protected $fillable = [];
}
```

### Auth Managers and Workers

Great, now we have to take a look at our authentication managers and workers in `config/authentication.php` file.

``` php
'manager_workers' => [
    // here we define our auth managers.
    SystemAuthManager::MANAGER => [
        // here we define our auth workers.
        EmailAuthWorker::class,
        PhoneAuthWorker::class,
        EmailOrPhoneAuthWorker::class,
    ],
],
```

The `manager_workers` array is responsible for defining the auth managers and workers.
and we can add our custom auth managers and workers.

The `AuthManager` is responsible for handling the system authentication process.

Each auth manager has its own workers, and each auth worker has its own authentication name/worker.

When we call `AuthManager` authenticate method,
it will call the matched auth worker with the given credentials.

We can add a custom auth worker to use it with the `SystemLoginProvider` auth manager or any other new auth manager.

### Auth Workers

you can use this command to create a new auth worker.


``` bash
php artisan core:make-auth-worker UsernameAuthWorker
```

``` php
<?php

namespace App\Http\Authentication\Workers;

use Raid\Core\Auth\Authentication\Contracts\AuthWorkerInterface;
use Raid\Core\Auth\Authentication\AuthWorker;

class UsernameAuthWorker extends AuthWorker implements AuthWorkerInterface
{
    /**
     * {@inheritdoc}
     */
    public const WORKER = '';
}

```

The `AuthWorker` class must implement `AuthWorkerInterface` interface.

The `AuthWorker` class must extend `AuthWorker` class.

The `WORKER` constant is responsible for defining the auth worker name.

The `WORKER` constant is used to match the auth worker with the given credentials.

The `WORKER` constant is used to define the accountable query column,
to override using same key for credentials and query, define the `QUERY_COLUMN` constant.

``` php
<?php

namespace App\Http\Authentication\Workers;

use Raid\Core\Auth\Authentication\Contracts\AuthWorkerInterface;
use Raid\Core\Auth\Authentication\AuthWorker;

class UsernameAuthWorker extends AuthWorker implements AuthWorkerInterface
{
    /**
     * {@inheritdoc}
     */
    public const WORKER = 'username';
    
    /**
     * {@inheritdoc}
     */
    public const QUERY_COLUMN = 'user_name';
}

```

The `QUERY_COLUMN` constant is used to define the accountable query column.

We need to define the new auth worker in `config/authentication.php` file.

``` php
'manager_workers' => [
    // here we define our auth managers.
    SystemAuthManager::MANAGER => [
        // here we define our auth workers.
        EmailAuthWorker::class,
        PhoneAuthWorker::class,
        EmailOrPhoneAuthWorker::class,
        UsernameAuthWorker::class,
    ],
],
```

Now let's try our new auth worker.

``` php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Raid\Core\Auth\Authentication\Managers\SystemAuthManager;

class AuthController extends Controller
{
    /**
     * Invoke the controller method.
     */
    public function __invoke(Request $request, SystemAuthManager $authManager): JsonResponse
    {
        $credentials = $request->only([
            'username', 'password',
        ]);

        $authManager = $authManager->authenticate(new User(), $credentials);

        return response()->json([
            'manager' => $authManager->manager(),
            'token' => $authManager->stringToken(),
            'errors' => $authManager->errors()->toArray(),
            'resource' => $authManager->account(),
        ]);
    }
}
```

The `SystemAuthManager` authenticate method accepts two parameters.

The first parameter is the accountable class instance.

The second parameter is the credentials array.

The `SystemAuthManager` authenticate method returns the `AuthManager` class instance.

The `AuthManager` class instance uses the credentials array to match with auth worker.

The `AuthManager` class instance used the matched worker to query the accountable class to find the matched account.

The `AuthManager` class apply its own authentication rules after finding the account.

The `Accountable` class instance must work with query builder to find the account.

Under the hood,
the `AuthWorker` class calles `findAccount` method in the `Accountable` class instance.


The returned account must be an instance of `AccountInterface` interface.

After finding the account, and apply the `AuthManager` rules,
you can apply authentication rules on the account itself using `isAuthenticated` method.

``` php
<?php

namespace App\Models;

use Raid\Core\Auth\Exceptions\Authentication\Login\LoginException;
use Raid\Core\Auth\Models\Authentication\Contracts\AccountInterface;
use Raid\Core\Auth\Models\Authentication\Account;

class User extends Account implements AccountInterface
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
            throw new LoginException(__('User is banned.'));
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

The `LoginException` will not be thrown in the system,
but the errors can be called with the `errors` method in the `AuthManager` instance.

The `errors` method will return an `Raid\Core\Model\Errors\Errors` instance.

Remember, any other exception but `LoginException` will be thrown in the system.

### Errors

You can work with the `errors` method as a `Illuminate\Support\MessageBag` instance,
and you can get your errors with different methods.

``` php
$loginProvider = $authManager->login(new User(), $credentials);

$errorsAsArray = $authManager->errors()->toArray();
$errorsAsJson = $authManager->errors()->toJson();

$allErrors = $authManager->errors()->all();

$errorsByKey = $authManager->errors()->get('error');

$firstError = $authManager->errors()->first();
$firstErrorByKey = $authManager->errors()->first('error');

$lastError = $authManager->errors()->last();
$lastErrorByKey = $authManager->errors()->last('error');
```

The `errors` method returns an `Raid\Core\Model\Errors\Errors` class instance.

The `toArray` method returns an array of errors.

The `toJson` method returns a json string of errors.

The `all` method returns all errors as an array.

The `get` method returns an array of errors for the given key.

The `first` method returns the first error, or the first error for the given key.

The `last` method returns the last error, or the last error for the given key.

You can work with `errors` method again in the `AuthManager` class.

### Auth Managers

You can create your own auth manager using this command.

``` bash
php artisan core:make-auth-manager OtpAuthManager
```

``` php
<?php

namespace App\Http\Authentication\Providers;

use Raid\Core\Auth\Authentication\Contracts\AuthManagerInterface;
use Raid\Core\Auth\Authentication\AuthManager;

class OtpAuthManager extends AuthManager implements LoginProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public const MANAGER = 'otp';
}
```

The `AuthManager` class must implement `AuthManagerInterface` interface.

The `AuthManager` class must extend `AuthManager` class.

The `Manager` constant is responsible for defining the authentication manager name.

The auth manager is the main class that handles the authentication process,
and it defines his own authentication rules and steps.

``` php
<?php

namespace App\Http\Authentication\Providers;

use Raid\Core\Auth\Authentication\Contracts\AuthManagerInterface;
use Raid\Core\Auth\Authentication\AuthManager;

class OtpAuthManager extends AuthManager implements LoginProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public const MANAGER = 'otp';

    /**
     * Get authentication rules.
     */
    public function rules(): array
    {
        return [];
    }
    
    /**
     * Get authentication steps.
     */
    public function steps(): array
    {
        return [];
    }
}
```

The `rules` method is responsible for defining the `AuthManager` authentication rules.

The `rules` method should return an array of authentication rules.

The `steps` method is responsible for defining the `AuthManager` authentication steps.

The `steps` method should return an array of authentication steps.

The `rules` run before the `steps`.

After running the `AuthManager` authentication steps, the authentication process will be stopped,
and the `AuthManager` will return the `AuthManager` instance.

We can skip using authentication rules and steps by returning an empty array.

#### Auth Rules

you can use this command to create a new auth rule.

``` bash
php artisan core:make-auth-rule VerifiedPhoneAuthRule
```

``` php
<?php

namespace App\Http\Authentication\Rules;

use Raid\Core\Auth\Authentication\Contracts\AuthManagerInterface;
use Raid\Core\Auth\Authentication\Contracts\AuthRuleInterface;

class VerifiedPhoneAuthRule implements AuthRuleInterface
{
    /**
     * Run an authentication ruler.
     */
    public function rule(AuthManagerInterface $authManager): bool
    {
    }
}
```

The `AuthRule` class must implement `AuthRuleInterface` interface.

The `rule` method is responsible for running the authentication rule.

The `rule` method should return a boolean value.

The `rule` method should return `true` if the authentication rule passed,

The `rule` method should add `errors` to `AuthManager` and return `false` if the authentication rule failed.

The `AuthManager` class instance will stop the authentication process if any authentication rule failed.

``` php
<?php

namespace App\Http\Authentication\Rules;

use Raid\Core\Auth\Authentication\Contracts\AuthManagerInterface;
use Raid\Core\Auth\Authentication\Contracts\AuthRuleInterface;

class VerifiedPhoneAuthRule implements AuthRuleInterface
{
    /**
     * Run an authentication ruler.
     */
    public function rule(AuthManagerInterface $authManager): bool
    {
        if ($authManager->account()->isVerified()) {
            return true;
        }

        $authManager->errors()->add('phone', __('Phone number is not verified.'));

        return false;
    }
}
```

We need to define the new auth rule in `AuthManager` class.

``` php
<?php

namespace App\Http\Authentication\Providers;

use App\Http\Authentication\Rules\VerifiedPhoneAuthRule;
use Raid\Core\Auth\Authentication\Contracts\AuthManagerInterface;
use Raid\Core\Auth\Authentication\AuthManager;

class OtpAuthManager extends AuthManager implements LoginProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public const MANAGER = 'otp';

    /**
     * Get authentication rules.
     */
    public function rules(): array
    {
        return [
            VerifiedPhoneAuthRule::class,
        ];
    }
}
```

The `AuthManager` class instance will stop the authentication process if the authentication rule failed.

#### Auth Steps

you can use this command to create a new auth step.

``` bash
php artisan core:make-auth-step OtpAuthStep
```

``` php
<?php

namespace App\Http\Authentication\Steps;

use Raid\Core\Auth\Authentication\Contracts\AuthManagerInterface;
use Raid\Core\Auth\Authentication\Contracts\AuthStepInterface;

class OtpAuthStep implements AuthStepInterface
{
    /**
     * Run an authentication step.
     */
    public function step(AuthManagerInterface $authManager): void
    {
    }
}
```

The `AuthStep` class must implement `AuthStepInterface` interface.

The `step` method is responsible for running the authentication step.

The `step` method should execute the authentication step.

The `step` method should add `errors` to `AuthManager` if the authentication step failed.

We need to define the new auth step in `AuthManager` class.

``` php
<?php

namespace App\Http\Authentication\Providers;

use App\Http\Authentication\Steps\OtpAuthStep;
use Raid\Core\Auth\Authentication\Contracts\AuthManagerInterface;
use Raid\Core\Auth\Authentication\AuthManager;

class OtpAuthManager extends AuthManager implements LoginProviderInterface
{
    /**
     * {@inheritdoc}
     */
    public const MANAGER = 'otp';

    /**
     * Get authentication steps.
     */
    public function steps(): array
    {
        return [
            OtpAuthStep::class,
        ];
    }
}
```

``` php
<?php

namespace App\Http\Authentication\Steps;

use Raid\Core\Auth\Authentication\Contracts\AuthManagerInterface;
use Raid\Core\Auth\Authentication\Contracts\AuthStepInterface;

class OtpAuthStep implements AuthStepInterface
{
    /**
     * Otp service.
     */
    protected OtpService $otpService;

    /**
     * Otp service.
     */
    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    /**
     * Run an authentication step.
     */
    public function step(AuthManagerInterface $authManager): void
    {
        $this->otpService->send($authManager->account());
    }
}
```

The `AuthManager` class instance will stop the authentication process after running all authentication steps.

### Authentication Facade

You can define a default authentication manager,
and use the `Raid\Core\Auth\Facades\Authentication` facade to process the authentication.

Define the default auth manager in `config/authentication.php` file.

``` php 
'default_auth_manager' => \App\Http\Authentication\Managers\OtpAuthManager::class,
```

``` php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Raid\Core\Auth\Authentication\Managers\SystemAuthManager;

class AuthController extends Controller
{
    /**
     * Invoke the controller method.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $credentials = $request->only([
            'username', 'password',
        ]);

        $authManager = Authentication::authenticate(new User(), $credentials);

        return response()->json([
            'manager' => $authManager->manager(),
            'token' => $authManager->stringToken(),
            'errors' => $authManager->errors()->toArray(),
            'resource' => $authManager->account(),
        ]);
    }
}
```

The `Authentication` facade is responsible for handling the authentication process.

The `Authentication` facade uses the `default_auth_manager` from the `config/authentication.php` file.

#

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

