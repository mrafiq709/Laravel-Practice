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
Create access token for client:
--------------------------------
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
UserController:
---------------
```php
<?php

namespace App\Http\Controllers\api\v1\user;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::all();
    }
 }
```
Routes:
---------------------------------------------------
```php
Route::prefix('/user')->group(function () {
    Route::post('/login', 'api\v1\LoginController@login');
    Route::middleware('auth:api')->get('/all', 'api\v1\user\UserController@index');
});
```
API Test (Postman):
-------------------
Get Access Token:
```diff
- POST: https://default.test/api/v1/user/login

+ Form Data:
+ email:mrafiq709@gmail.com
+ password:password
```
response:
```json
{
    "user": {
        "id": 1,
        "name": "Rafiq",
        "email": "mrafiq709@gmail.com",
        "email_verified_at": null,
        "created_at": "2021-03-13T10:26:12.000000Z",
        "updated_at": "2021-03-13T10:26:12.000000Z"
    },
    "access_token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiIxIiwianRpIjoiM2MwYWEyYTM3YjM1OTYzYmYyZjBkZTc3YTJlOWNlYzhhZDZiOGM3MWRhZGVkNzMwYjRlMDNjNjQ2MGE4MGVlY2JhY2FiMGYxM2NhYTk1MDIiLCJpYXQiOjE2MTU2MzU1NzEsIm5iZiI6MTYxNTYzNTU3MSwiZXhwIjoxNjQ3MTcxNTcxLCJzdWIiOiIxIiwic2NvcGVzIjpbXX0.FuLGrjDEDth1ao9cqjNajvlbQ-np7C0opwBOtAh5hC-2PNHD2aCFNHjbfW5VRTMDes3zcubuiUNmIVPaWwKCEemiqxYIB0W3zNSW_f8UDJWL1uZIyjKejfaW2Y1JkkCEpPhA5YPP9ATlQ4V2ipA-5DSfBfm8roXMBYWtdhbC6elQBcmY807RmkVLlzsAzFl5ci8ySK67TkcEAGIpLmIaNc3NDM7kGPZgZDP0zRD5IXvLbNzoOiGsds8VeQCSL7vMANadzRQxe4GCmhSnjCqe1HcsB-jJly0QOeZ8JnSkAf5K5hE7CDg8ULm8fO5dfuyzxNHinr52a3B1JogLc4eCTd3RTwmsMd__2Knp0AsbJHtjxy7B98Vsgc2LeRNjnfW4W_jw_3GTLdDeq5E0DV3zxZ7VjtWziP9joJvyxrGAUw0l5DMUHZP5ognwHF0LiDPOjlhgyuFXP040SlTRpxZQYfKehc7AJnEZF4wKXd6EckurUiTzyBE_z3SoIejUkNjQ1G-be8F5AQEOYh6Prm0i16mSQFb2BcmM9xc9nMOJcZDkPL-e0Tn1YpDwUSny_NPIrLKf47VhpK3hgHoTmw-1bFoxINeMzEcRm7BK6JGa1kAsP5AyAmyBoRO-iLaKHcvOylMt4BEyAiY-7rJ0Qd2L5vhruvdHezRkh0fIJgHWSYM"
}
```
Get All user using access token:
```diff
- GET: https://default.test/api/v1/user/all

+ 1. Authorization tab
+ 2. Select Bearer Token
+ 3. Token: access_token
```
response:
```json
[
    {
        "id": 1,
        "name": "Rafiq",
        "email": "mrafiq709@gmail.com",
        "email_verified_at": null,
        "created_at": "2021-03-13T10:26:12.000000Z",
        "updated_at": "2021-03-13T10:26:12.000000Z"
    }
]
```

##### references:

https://www.youtube.com/watch?v=R3Hec0_U2Cs&list=LL_bgeF1yjKHFtFH1gM8sojA&index=6&t=1129s

https://laravel.com/docs/8.x/passport
