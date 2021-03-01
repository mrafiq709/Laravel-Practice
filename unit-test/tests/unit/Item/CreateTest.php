<?php
namespace Item;

use Carbon\Carbon;
use Faker\Factory;

class CreateTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
    }

    protected function _after()
    {
    }

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
}