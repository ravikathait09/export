<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Database\Seeder;

class TransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        
        $row = [];

        for ($i = 0; $i < 100000; $i++) {
            $row[] = [
                'amount'        => rand(10000, 99999),
                'description'   => $faker->sentence(),
                'first_name' => $faker->firstName(),
                'last_name' => $faker->lastName(),
                'phone' => $faker->phoneNumber(),
                'address' => $faker->address(),
                'city' => $faker->city(),
                'pincode'       => $faker->postcode(),
                'created_at'    => now(),
                'updated_at'    => now(),
                'user_id'=>$i+1
            ];
            if($i%1000){
                Transaction::insert($row);
                $row =[];
            }
        }

        
    }
}
