# Unit Test Codeception
```
php artisan make:migration Item

Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->timestamps();
        });
        
php artisan migrate
```
Make item Model:
```
php artisan make:model Item

class Item extends Model
{
    protected $table = "items";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'description', 'created_at', 'updated_at'
    ];
}
```
```
php artisan make:seeder ItemsTableSeeder

public function run()
    {
        $faker      = Faker::create('App/Item');

        DB::table('items')->insert([
            'title'         => $faker->sentence(),
            'description'   => implode($faker->paragraphs(5)),
            'created_at'    => Carbon::now(),
            'updated_at'    => Carbon::now()
        ]);
    }
    
 php artisan db:seed --class=ItemsTableSeeder
 ```
 Getting Started with Codeception:
 -----------------------------------
 ```
 composer require codeception/codeception --dev
 composer exec codecept bootstrap
 cp .env .env.testing
 ```
 Functional Tests:
 ------------------
 To start you need to configure **tests/functional.suite.yml** to use Laravel5 module:
 ```
 actor: FunctionalTester
modules:
    enabled:
        # add a framework module here
        - Laravel5:
              environment_file: .env.testing
        - \Helper\Functional
 ```
  Unit Tests:
 ------------------
 Configure **tests/unit.suite.yml** to use Laravel5 module:
 ```
 actor: UnitTester
modules:
    enabled:
        - Asserts
        - \Helper\Unit
        - Laravel5:
            part: ORM
            environment_file: .env.testing
            cleanup: true
            run_database_migrations: true
  ```
   
  Build config :
  ---------------
  ```
  composer require codeception/module-laravel5 --dev
  vendor/bin/codecept build
  ```
  Unit Tests:
  -------------
  To genereate a unit test run:
  ```
  composer exec codecept g:test unit "Item\CreateTest"
  
  // tests
    public function testSomeFeature()
    {
        $faker          = Factory::create('App\Item');
        $title          = $faker->sentence();
        $description    = implode($faker->paragraphs(5));
        $created_at     = Carbon::now();
        $updated_at     = Carbon::now();

        $this->tester->haveRecord(
            'App\Item',
            ['title' => $title, 'description' => $description, 'created_at' => $created_at, 'updated_at' => $updated_at]
        );

        $this->tester->seeRecord(
            'items',
            ['title' => $title, 'description' => $description, 'created_at' => $created_at, 'updated_at' => $updated_at]
        );
    }
```
run it by the following command here :
```
vendor/bin/codecept run unit --coverage-html
```
API Test:
----------

```
  composer require codeception/module-phpbrowser --dev
  composer require codeception/module-asserts --dev
  composer require codeception/module-rest --dev
```

Configure **tests/api.suite.yml**:
----------------------------------
   ```
   actor: ApiTester
   modules:
      enabled:
        - \Helper\Api
        - Asserts
        - REST:
            depends: Laravel5
            part: Json
        - Laravel5:
            cleanup: true
            run_database_migrations: true
            disable_middleware: false
            part: ORM
            environment_file: .env.testing
   ```
 Add Api.php Class:
 -------------------
  ```
 tests
    |_ _support
          |_Helper
               |_Api.php
 ```
 ```php
 <?php
namespace Helper;

use Codeception\Exception\ModuleException;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Api extends \Codeception\Module
{

    /**
     * @param $abstract
     * @param $instance
     *
     * @return bool
     */
    public function bindInstance($abstract, $instance)
    {
        try {
            $laravel = $this->getModule('Laravel5');
            /**
             * @var Application $app
             */
            $app = $laravel->getApplication();
            $app->instance($abstract, $instance);
            $laravel->setApplication($app);
        } catch (ModuleException $e) {
            return false;
        }
    }

}

 ```
 
 Add ApiTester.php Class:
 ---------------------
 ```
 tests
    |_ _support
          |_ApiTester.php
 ```

 ```php
 <?php

use Codeception\Actor;
use Codeception\Step\Action;
use Faker\Generator;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause()
 *
 * @SuppressWarnings(PHPMD)
 */
class ApiTester extends Actor
{
    use _generated\ApiTesterActions;

    /**
     * @return false|string|null
     */
    public function getAccessToken()
    {
        return env('ACCESS_TOKEN', null);
    }

    /**
     * Set HTTP headers to the ApiTester
     * To use API Key for authorizing, pass true to $apiKey
     * To use access token for authorizing, pass false to $apiKey
     *
     * @param      $token
     * @param bool $apiKey
     */
    public function httpHeader($token, $apiKey = false)
    {
        if ($apiKey) {
            $this->haveHttpHeader('X-Authorization', $token);
        } else {
            $this->haveHttpHeader('Authorization', 'Bearer ' . $token);
        }
        $this->haveHttpHeader('accept', 'application/json');
        $this->haveHttpHeader('content-type', 'application/json');
    }

    /**
     * Mock the client
     *
     * @param int $num
     *
     * @throws Exception
     */
    public function mockClient($num = 1)
    {
        $responses = [];
        for ($i = 0; $i < $num; $i++) {
            $responses[] = new Response(200, [], json_encode(['ok' => true]));
        }
        $mock = new MockHandler($responses);
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
        $this->bindInstance(Client::class, $client);
    }

    public function mockUser(Generator $faker)
    {
        $responses = [
            new Response(200, [], json_encode([
                "id" => $faker->randomDigitNotZero(),
                "name" => $faker->name,
                "email" => $faker->email,
                "password" => $faker->password
            ]))
        ];

        $mock = new MockHandler($responses);
        $handler = HandlerStack::create($mock);
        $client = new Client(['handler' => $handler]);
        $this->bindInstance(Client::class, $client);
    }
    
    /**
     *
     * @throws Exception
     */
    public function setToken(bool $superAdmin = false)
    {
        $user = factory(User::class)->create();

        if($superAdmin)
        {
            $user->email = 'islam@funtap.vn';
            $user->save();
        }

        $token = $this->generateToken($user);

        $this->haveHttpHeader('Authorization', "Bearer $token");
        $this->setHeaders();
    }

    public function setHeaders()
    {
        $this->haveHttpHeader('accept', 'application/json');
        $this->haveHttpHeader('content-type', 'application/json');
    }


    /**
     * @param User $user
     *
     * @return string
     */
    public function generateToken(User $user): string
    {
        $keyName = sprintf('passport-public-key' . DIRECTORY_SEPARATOR . '%s-oauth-private.key', config('app.env'));
        $keyPath = storage_path($keyName);

        return JWT::encode(
            [
                'aud'    => $user->id,
                'iat'    => time(),
                'nbf'    => time(),
                'exp'    => time() + 60 * 60,
                'sub'    => $user->id,
                'scopes' => [],
                'user'   => $user->toArray(),
            ],
            file_get_contents($keyPath),
            'RS256'
        );
    }

    /**
     * [!] Method is generated. Documentation taken from corresponding module.
     *     *
     *
     * @param $abstract
     * @param $instance
     *
     * @return mixed|null
     * @throws Exception
     * @see \Helper\Api::bindInstance()
     */
    public function bindInstance($abstract, $instance)
    {
        return $this->getScenario()->runStep(new Action('bindInstance', func_get_args()));
    }

    /**
     * @throws Exception
     */
    public function cleanupMongoDb()
    {
        
    }
}
 ```
 Create APi Test:
 -------------------
 ```
 php vendor/bin/codecept generate:cest api CreateUser
 ```
 ```php
 <?php

use Codeception\Util\HttpCode;
use Faker\Factory;

class CreateUserCest
{
    protected $uri = '/api/v2/users';
    /**
     * @var false|string|null
     */
    private $token;
    private $user;

    public function _before(ApiTester $I)
    {
        $I->setToken(true);
        $this->user = User::all()->first();
        
        // $this->token = $I->getAccessToken();

        // $I->httpHeader($this->token);

        // $faker = Factory::create();
        // $I->mockUser($faker);
    }

    /**
     * @param ApiTester $I
     *
     * @throws Exception
     */
    public function userIndex(ApiTester $I)
    {
        $I->sendGet($this->uri);

        $I->seeResponseCodeIs(HttpCode::OK);
        $I->seeResponseIsJson();

        $count = $I->grabDataFromResponseByJsonPath('$.data.total')[0];
        $total = User::all()->count();

        $I->assertEquals($count, $total);
    }
}
 ```
 
 run it by the following command here :
```
vendor/bin/codecept run api Example.php:createTest --coverage-html
vendor/bin/codecept run api --coverage-html
```
 
##### Reference:
https://medium.com/dot-lab/automatic-testing-laravel-project-use-codeception-f79fb19b9626
https://codeception.com/docs/10-APITesting
