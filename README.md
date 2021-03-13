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
```php Laravel\Passport\HasApiTokens``` trait to your ```php App\Models\User``` model.
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

##### references:

https://www.youtube.com/watch?v=R3Hec0_U2Cs&list=LL_bgeF1yjKHFtFH1gM8sojA&index=6&t=1129s
