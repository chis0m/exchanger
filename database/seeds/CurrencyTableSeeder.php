<?php

use Illuminate\Database\Seeder;
use App\Services\CurrencyService;

class CurrencyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        (new CurrencyService)->populateCurrencyTable();
    }
}
