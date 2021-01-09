<?php

use Illuminate\Database\Seeder;
use App\Models\Configuration;

class ConfigurationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Configuration::create([
            'title' => 'Number of Currencies',
            'slug' => 'number_of_currencies',
            'value' => Configuration::RANGE[1],
            'description' => 'Number of currencies a user can set as base currency. For fixer free plan, it is one(EUR) or many',
        ]);
        Configuration::create([
            'title' => 'Time in between update',
            'slug' => 'time_in_between_upate',
            'value' => '3600',
            'description' => 'Time in seconds. For fixer free plan, it is hourly'
        ]);
        Configuration::create([
            'title' => 'Currency Exchange Provider',
            'slug' => 'currency_exchange_provider',
            'value' => 'fixer',
            'description' => 'Set the exchange provider here'
        ]);
    }
}
