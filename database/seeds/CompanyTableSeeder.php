<?php

use App\Company;
use Illuminate\Database\Seeder;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('companies')->insert(
            [
                ['name' => 'Ashok Company', 'email' => 'Ashok@company.com', 'address' => 'Hetauda 4 Karra', 'phone' => '9865011077'],

            ]
        );
    }
}
