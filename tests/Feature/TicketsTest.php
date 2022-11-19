<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TicketsTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_tickets_page_contains_empty_table()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/tickets');
        
        $response->assertStatus(200);
        $response->assertSee('No tickets found.');

        $response->assertStatus(200);
    }

    public function test_tickets_page_contains_non_empty_table()
    {
        $user = User::factory()->create();
        $ticket = 
        $response = $this->actingAs($user)->get('/tickets');
        
        $response->assertStatus(200);
        $response->assertSee('No tickets found.');

        $response->assertStatus(200);
    }
}
