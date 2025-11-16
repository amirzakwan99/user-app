<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 60; $i++) {
            $phoneNum = '+601' . $faker->numerify('########'); 
            User::create([
                'name' => $faker->name(),
                'email' => $faker->safeEmail(),
                'phone_number' => $phoneNum,
                'password' => 'secret',
                'status' => User::STATUS_ACTIVE
            ]);
        }
    }
}
