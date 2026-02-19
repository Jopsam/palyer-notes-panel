<?php

namespace Database\Seeders;

use App\Enums\Roles;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * @return void
     */
    public function run(): void
    {
        Role::create(['name' => Roles::PLAYER->value]);
        $agent = Role::create(['name' => Roles::AGENT->value]);
        
        // We use firstOrCreate here to avoid creating duplicate permissions if the seeder is run multiple times.
        $permission = Permission::firstOrCreate(['name' => 'create player notes']);

        $agent->givePermissionTo($permission);
    }
}
