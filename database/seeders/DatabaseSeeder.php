<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@evamulia.test',
            'role' => 'admin',
            'password' => 'password',
        ]);

        User::query()->create([
            'name' => 'User Klinik',
            'username' => 'user',
            'email' => 'user@evamulia.test',
            'role' => 'user',
            'password' => 'password',
        ]);
    }
}
