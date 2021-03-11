<?php

use Illuminate\Database\Seeder;

class UnitTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('units')->insert(
            [
                ['user_id' => 1, 'name' => 'Gram', 'description' => 'This is an example unit. Its strange that this seeder is for all the unit. However, since its a test record, it does not really matter! I am trying to write as bug paragraph I can.'],
                ['user_id' => 1, 'name' => 'KG', 'description' => 'This is an example unit. Its strange that this seeder is for all the unit. However, since its a test record, it does not really matter! I am trying to write as bug paragraph I can.'],
                ['user_id' => 1, 'name' => 'Quinta', 'description' => 'This is an example unit. Its strange that this seeder is for all the unit. However, since its a test record, it does not really matter! I am trying to write as bug paragraph I can.'],
                ['user_id' => 1, 'name' => 'Ton', 'description' => 'This is an example unit. Its strange that this seeder is for all the unit. However, since its a test record, it does not really matter! I am trying to write as bug paragraph I can.'],
                ['user_id' => 1, 'name' => 'Couple', 'description' => 'This is an example unit. Its strange that this seeder is for all the unit. However, since its a test record, it does not really matter! I am trying to write as bug paragraph I can.'],
                ['user_id' => 1, 'name' => 'Dozen', 'description' => 'This is an example unit. Its strange that this seeder is for all the unit. However, since its a test record, it does not really matter! I am trying to write as bug paragraph I can.'],
                ['user_id' => 1, 'name' => 'Single', 'description' => 'This is an example unit. Its strange that this seeder is for all the unit. However, since its a test record, it does not really matter! I am trying to write as bug paragraph I can.'],
                ['user_id' => 1, 'name' => 'Piece', 'description' => 'This is an example unit. Its strange that this seeder is for all the unit. However, since its a test record, it does not really matter! I am trying to write as bug paragraph I can.'],
            ]
        );
    }
}
