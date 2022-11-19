<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AgentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'role_id' => Role::AGENT_ID,
            'name' => 'agent',
            'email' => 'agent@agent.com',
            'password' => bcrypt('password'),
        ]);

        User::create([
            'role_id' => Role::AGENT_ID,
            'name' => 'agent2',
            'email' => 'agent2@agent2.com',
            'password' => bcrypt('password'),
        ]);
    }
}
