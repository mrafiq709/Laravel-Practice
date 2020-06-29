<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=0; $i<5; $i++)
        {
            DB::table('countries')->insert([
                'name' => Str::random(10),
                'flag_url' => 'http://en.banglapedia.org/images/3/34/NationalFlag.jpg',
                'user_id' => 1
            ]);
        }
    }
}
