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
            'name' => 'exchanger',
            'email' => 'exchanger@credpal.com',
            'password' => bcrypt('password'),
        ]);
    }
}
