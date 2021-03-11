<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert(
            [
                ['user_id' => 1, 'company_id' => 1, 'name' => 'Coffee', 'description' => 'This is an example product. Its strange that this seeder is for all the category. However, since its a test record, it does not really matter! I am trying to write as bug paragraph I can.'],
                ['user_id' => 1, 'company_id' => 1, 'name' => 'Biscuit', 'description' => 'This is an example product. Its strange that this seeder is for all the category. However, since its a test record, it does not really matter! I am trying to write as bug paragraph I can.'],
                ['user_id' => 1, 'company_id' => 1, 'name' => 'Noodles', 'description' => 'This is an example product. Its strange that this seeder is for all the category. However, since its a test record, it does not really matter! I am trying to write as bug paragraph I can.'],
                ['user_id' => 1, 'company_id' => 1, 'name' => 'Chocolate', 'description' => 'This is an example product. Its strange that this seeder is for all the category. However, since its a test record, it does not really matter! I am trying to write as bug paragraph I can.'],
                ['user_id' => 1, 'company_id' => 1, 'name' => 'Wafers', 'description' => 'This is an example product. Its strange that this seeder is for all the category. However, since its a test record, it does not really matter! I am trying to write as bug paragraph I can.'],
                ['user_id' => 1, 'company_id' => 1, 'name' => 'Digestive', 'description' => 'This is an example product. Its strange that this seeder is for all the category. However, since its a test record, it does not really matter! I am trying to write as bug paragraph I can.'],
                ['user_id' => 1, 'company_id' => 1, 'name' => 'Pencil', 'description' => 'This is an example product. Its strange that this seeder is for all the category. However, since its a test record, it does not really matter! I am trying to write as bug paragraph I can.'],
                ['user_id' => 1, 'company_id' => 1, 'name' => 'Pen', 'description' => 'This is an example product. Its strange that this seeder is for all the category. However, since its a test record, it does not really matter! I am trying to write as bug paragraph I can.'],
                ['user_id' => 1, 'company_id' => 1, 'name' => 'Copy', 'description' => 'This is an example product. Its strange that this seeder is for all the category. However, since its a test record, it does not really matter! I am trying to write as bug paragraph I can.'],
                ['user_id' => 1, 'company_id' => 1, 'name' => 'Book', 'description' => 'This is an example product. Its strange that this seeder is for all the category. However, since its a test record, it does not really matter! I am trying to write as bug paragraph I can.'],
                ['user_id' => 1, 'company_id' => 1, 'name' => 'Oil', 'description' => 'This is an example product. Its strange that this seeder is for all the category. However, since its a test record, it does not really matter! I am trying to write as bug paragraph I can.'],
                ['user_id' => 1, 'company_id' => 1, 'name' => 'Soft Drinks', 'description' => 'This is an example product. Its strange that this seeder is for all the category. However, since its a test record, it does not really matter! I am trying to write as bug paragraph I can.'],
                ['user_id' => 1, 'company_id' => 1, 'name' => 'Rice', 'description' => 'This is an example product. Its strange that this seeder is for all the category. However, since its a test record, it does not really matter! I am trying to write as bug paragraph I can.'],
                ['user_id' => 1, 'company_id' => 1, 'name' => 'Wheat', 'description' => 'This is an example product. Its strange that this seeder is for all the category. However, since its a test record, it does not really matter! I am trying to write as bug paragraph I can.'],
                ['user_id' => 1, 'company_id' => 1, 'name' => 'Flour', 'description' => 'This is an example product. Its strange that this seeder is for all the category. However, since its a test record, it does not really matter! I am trying to write as bug paragraph I can.'],
            ]
        );
    }
}
