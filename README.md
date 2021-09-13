# Laravel-Permission-Spatie

Laravel Permission Spatie

```
composer show spatie/laravel-permission
composer require spatie/laravel-permission
php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider"
php artisan config:clear
php artisan migrate
```

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class CreateRolePermission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $guard = 'api';
        Role::create(['name' => 'admin', 'guard_name' => $guard]);
        Permission::create(['name' => 'admin.view', 'guard_name' => $guard]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
```

```
php artisan migrate
```

```php
<?php

namespace App\Http\Controllers\User;

use App\User;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Request;
use Auth;

class PermissionController extends Controller
{

    /**
     * Add Permission
     */
    public function add(Request $request)
    {
        $user = User::where('email', $request->email)->get()->first();
        $role = Role::findByName('admin');
        $user->makeHidden('email');
        $user->assignRole($role);
        $user->givePermissionTo('admin.view');
        $user->roles();

        return request()->json($user->toArray());
    }

    /**
     * Retrive Permission
     */
    public function user(Request $request)
    {
        $user = Auth::user();
        $user->roles;
        $user->permissions;

        return request()->json($user->toArray());
    }
}
```

##### Refernces

https://spatie.be/docs/laravel-permission/v5/installation-laravel

https://github.com/spatie/laravel-permission
