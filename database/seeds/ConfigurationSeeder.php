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
        ]);
    }
}
