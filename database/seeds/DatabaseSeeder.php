<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(AdminSeeder::class);
        $this->call(CompanyTableSeeder::class);
        $this->call(UsersTableSeeder::class);
        $this->call(CategoryTableSeeder::class);
        $this->call(UnitTableSeeder::class);
        $this->call(SupplierTableSeeder::class);
        $this->call(CustomerTableSeeder::class);
        $this->call(BrandTableSeeder::class);
        $this->call(ProductTableSeeder::class);
    }
}
