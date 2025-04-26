<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()
            ->vendor()
            ->create();

        User::factory(20)
            ->user()
            ->create();

        User::factory()
            ->superAdmin()
            ->create([
                'name'  => 'Test User',
                'email' => 'test@example.com',
                'phone' => fake()->phoneNumber(),
            
            ]);
    }
}
