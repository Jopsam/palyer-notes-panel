<?php

namespace Database\Seeders;

use App\Enums\Roles;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * @return void
     */
    public function run(): void
    {
        // Create a support agent with a known email for testing purposes.
        User::factory()->agent()->create([
            'name' => 'Support Agent',
            'email' => 'agent@test.com',
        ]);

        // Create 20 player accounts.
        User::factory(20)->player()->create();
    }
}
