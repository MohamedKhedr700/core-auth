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
            'email', 'phone', 'username', 'password',
        ]);

        $loginProvider = $systemLoginProvider->login(new User(), $credentials);

        // or using static call
        $loginProvider = SystemLoginProvider::attempt(User::class, $credentials);

        // or using accountable static call
        $loginProvider = User::login($credentials);

        return response()->json([
            'token' => $loginProvider->getStringToken(),
            'resource' => $loginProvider->account(),
        ]);
    }
}
```

# How to work this

Let's start with our accountable class ex:`User` model.
to create our model class we can use this command.

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
        UsernameLoginManager::class,
        EmailOrPhoneLoginManager::class,
    ],
],
```

As you can see we have two providers `DeviceLoginProvider` and `SystemLoginProvider`.

The `DeviceLoginProvider` is responsible for handling the device login process.

The `SystemLoginProvider` is responsible for handling the system login process.


And that's it.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Credits

- **[Mohamed Khedr](https://github.com/MohamedKhedr700)**

## Security

If you discover any security-related issues, please email
instead of using the issue tracker.

## About Raid

Raid is a PHP framework created by **[Mohamed Khedr](https://github.com/MohamedKhedr700)**

and it is maintained by **[Mohamed Khedr](https://github.com/MohamedKhedr700)**.

## Support Raid

Raid is an MIT-licensed open-source project. It's an independent project with its ongoing development made possible.

