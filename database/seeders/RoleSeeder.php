<?php

namespace Database\Seeders;

use App\Enums\Permissions;
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
        $viewer = Role::create(['name' => Roles::VIEWER->value]);
        
        // We use firstOrCreate here to avoid creating duplicate permissions if the seeder is run multiple times.
        $viewPlayerNotePermission = Permission::firstOrCreate(['name' => Permissions::VIEW_PLAYER_NOTES->value]);
        $createPlayerNotePermission = Permission::firstOrCreate(['name' => Permissions::CREATE_PLAYER_NOTES->value]);

        $agent->givePermissionTo([$viewPlayerNotePermission, $createPlayerNotePermission]);
        $viewer->givePermissionTo($viewPlayerNotePermission);
    }
}
