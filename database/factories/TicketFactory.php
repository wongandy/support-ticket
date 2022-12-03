<?php

namespace Database\Factories;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->whereRoleId(Role::USER_ID)->first(),
            'assigned_to' => User::inRandomOrder()->whereRoleId(Role::AGENT_ID)->first(),
            'title' => fake()->sentence(),
            'message' => fake()->sentence(),
        ];
    }
}
