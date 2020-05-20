<?php

use Illuminate\Database\Seeder;
use App\Admin;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Admin::truncate();
        DB::table('admins')->insert([
            'name' => 'admin',
            'email' => 'admin@credpal.com',
            'password' => bcrypt('password'),
        ]);
    }
}
