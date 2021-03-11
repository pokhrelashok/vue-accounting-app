<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert(
            [
                ['name' => 'Ashok Pahadi', 'email' => 'pokhrelashok2@gmail.com', 'password' => Hash::make('admin@123'), 'company_id' => 1],
            ]
        );
    }
}
