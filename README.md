## Api using Laravel Passport

Install Passport:
--------------------
```
composer require laravel/passport
php artisan migrate
```
Create Client ID & Client Secret
```
php artisan passport:install
```
After running the ***passport:install*** command, add the 
***Laravel\Passport\HasApiTokens*** trait to your ***App\Models\User*** model.
```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
}
```
Next, you should call the ***Passport::routes*** method within the **boot** method of your ***App\Providers\AuthServiceProvider***
```php
<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        if (! $this->app->routesAreCached()) {
            Passport::routes();
        }
    }
}
```
Finally, in your application's 
```diff config/auth.php``` configuration file, you should set the ***driver*** option of the api authentication guard to passport. This will instruct your application to use Passport's TokenGuard when authenticating incoming API requests:

##### references:

https://www.youtube.com/watch?v=R3Hec0_U2Cs&list=LL_bgeF1yjKHFtFH1gM8sojA&index=6&t=1129s
