<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // User::truncate();
        DB::table('users')->insert([
            'first_name' => 'user',
            'last_name' => 'user',
            'base_currency' => 'EUR' ,
            'email' => 'user@exchanger.com',
            'password' => bcrypt('password'),
        ]);
    }
}
