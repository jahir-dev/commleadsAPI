<?php

use Illuminate\Database\Seeder;

class BuyersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\models\Buyer::class, 50)->create();
    }
}
