##### Install tailwindcss
https://tailwindcss.com/docs/guides/laravel

If there is problem during ***npm install && npm run dev*** then run below code OR try different version installation
```
npm uninstall autoprefixer postcss tailwindcss
npm install tailwindcss@npm:@tailwindcss/postcss7-compat @tailwindcss/postcss7-compat postcss@^7 autoprefixer@^9
npm install && npm run dev
```
Blade Component
-----------------
https://laravel.com/docs/8.x/blade#components
```
php artisan make:component ComponentName

```

Repositories & Custom Service Provider
-----------------------------------------
Folder Structure:
app
|__Repositories
|       |__OrderInterface.php
|       |__OrderRepository1.php
|       |__RepositoryServiceProvider.php
|
|__Http
|    |__OrderController.php
|
|__config
     |__app.php

1. Create OrderInterface.php
```
<?php
namespace App\Repositories;

interface OrderInterface {
    public function all();
    public function get($id);
    public function store(array $data);
    public function update(array $data);
    public function delete($id);
}
```

2. Create OrderRepository1.php and implements OrderInterface
```
<?php
namespace App\Repositories;

use App\Order;

class OrderRepository1 implements OrderInterface {
    
    public function all()
    {
        return Order::all();
    }

    public function get($id)
    {
        return "something";
    }

    public function store(array $data)
    {
        return "something";
    }

    public function update(array $data)
    {
        return "something";
    }

    public function delete($id)
    {
        return "something";
    }
}
```

3. Create OrderController.php
```
<?php

namespace App\Http\Controllers;

use App\Repositories\OrderRepository1;
use App\Repositories\OrderInterface;

class OrderController extends Controller
{
    public $order;

    public function __construct(OrderInterface $order)
    {
        $this->order = $order;
    }

    public function index() {
        $orders = $this->order->all();
        return view('index', compact('orders'));
    }
}
```

4. Custom Service Provider: Create RepositoryServiceProvider.php
And define which interface should bind with which repository
```
<?php

namespace App\Repositories;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider {
    public function register()
    {
        $this->app->bind(
            'App\Repositories\OrderInterface',
            'App\Repositories\OrderRepository1'
        );
    }
}
```
5. Update app.php
```
 // Custom Service Provider
 App\Repositories\RepositoryServiceProvider::class,
```

Done !. Now If your data is not related to model directly. You do not 
need to change controller if your data source change. You have to just
update your repository name.

##### Refernces
https://laravel.com/docs/8.x/mix#tailwindcss
https://tailwindcss.com/docs/guides/laravel
