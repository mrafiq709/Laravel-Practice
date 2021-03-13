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
***config/auth.php*** configuration file, you should set the ***driver*** option of the ***api*** authentication guard to ***passport***. This will instruct your application to use Passport's TokenGuard when authenticating incoming API requests:
```php
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],

    'api' => [
        'driver' => 'passport',
        'provider' => 'users',
    ],
],
```
Get access token for client:
```php
<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request) {

        $login = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

        if(! Auth::attempt($login)) {
            return response(['message' => 'Invalid credential']);
        }

        $accesstoken = Auth::user()->createToken('authToken')->accessToken;

        return response(['user' => Auth::user(), 'access_token' => $accesstoken]);
    }
}
```
Go to ***routes/api.php*** and add the login route:
```php
Route::prefix('/user')->group(function () {
    Route::post('/login', 'api\v1\LoginController@login');
    Route::middleware('auth:api')->get('/all', 'api\v1\user\UserController@index');
});
```
##### references:

https://www.youtube.com/watch?v=R3Hec0_U2Cs&list=LL_bgeF1yjKHFtFH1gM8sojA&index=6&t=1129s
https://laravel.com/docs/8.x/passport
