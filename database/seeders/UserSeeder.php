<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use DB;
use Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Tansib',
            'email' => 'tansib.muhaimin@northsouth.edu',
            'password' => Hash::make('password'),
        ]);
    }
}
