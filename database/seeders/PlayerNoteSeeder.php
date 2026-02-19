<?php

namespace Database\Seeders;

use App\Enums\Roles;
use App\Models\PlayerNote;
use App\Models\User;
use Illuminate\Database\Seeder;

class PlayerNoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * 
     * @return void
     */
    public function run(): void
    {
        $agent = User::role(Roles::AGENT->value)->first();
        if (!$agent) {
            $this->command->error('No support agent found. Run UserSeeder first.');
            return;
        }
        
        $players = User::role(Roles::PLAYER->value)->get();
        foreach ($players as $player) {
            PlayerNote::factory(3)->create([
                'player_id' => $player->id,
                'author_id' => $agent->id,
            ]);
        }
    }
}
