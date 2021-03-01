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
 Also yo need to configure tests/unit.suite.yml to use Laravel5 module:
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
  And then, build with following command :
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
vendor/bin/codecept run --coverage-html
```
  
##### Reference:
https://medium.com/dot-lab/automatic-testing-laravel-project-use-codeception-f79fb19b9626
