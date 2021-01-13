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
        try {
            (new CurrencyService)->populateCurrencyTable();
        } catch (Exception $e) {
            $code = $e->getCode();
            if($code == 0) dd('Internet Connection is required to run this seeder');
            dd($e->getMessage());
        }
    }
}
