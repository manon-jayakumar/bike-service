<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'John',
            'email' => 'john@gmail.com',
            'mobile' => '1234567890',
            'role' => 'owner',
            'password' => '12345678',
        ]);
    }
}
