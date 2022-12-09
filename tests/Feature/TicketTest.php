<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Role;
use App\Models\User;
use App\Models\Ticket;
use Illuminate\Support\Facades\Storage;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;

class TicketTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_user_can_see_empty_table()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/tickets');
        
        $response->assertSee('No tickets found.');
        $response->assertStatus(200);
    }

    public function test_user_can_see_non_empty_table()
    {
        $user = User::factory()->create();
        $ticket = Ticket::factory()->create();

        $response = $this->actingAs($user)->get('/tickets');
        
        $response->assertStatus(200);
        $response->assertDontSee('No tickets found.');
        $response->assertSee($ticket->title);
    }

    public function test_user_can_see_create_button_in_tickets_page()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get('/tickets');
        
        $response->assertStatus(200);
        $response->assertSee('Create');
    }

    public function test_user_cannot_see_edit_button_in_tickets_page()
    {
        $user = User::factory()->create();
        $ticket = Ticket::factory()->create();

        $response = $this->actingAs($user)->get('/tickets');
        
        $response->assertStatus(200);
        $response->assertDontSee('Edit');
    }

    public function test_user_cannot_see_delete_button_in_tickets_page()
    {
        $user = User::factory()->create();
        $ticket = Ticket::factory()->create();

        $response = $this->actingAs($user)->get('/tickets');
        
        $response->assertStatus(200);
        $response->assertDontSee('Delete');
    }

    public function test_agent_cannot_see_create_button_in_tickets_page()
    {
        $agent = User::factory()->create(['role_id' => Role::AGENT_ID]);

        $response = $this->actingAs($agent)->get('/tickets');
        
        $response->assertStatus(200);
        $response->assertDontSee('Create');
    }

    public function test_agent_can_see_edit_button_in_tickets_page()
    {
        $user = User::factory()->create();
        $agent = User::factory()->create(['role_id' => Role::AGENT_ID]);
        $ticket = Ticket::factory()->create(['assigned_to' => $agent->id]);

        $response = $this->actingAs($agent)->get('/tickets');
        
        $response->assertStatus(200);
        $response->assertSee('Edit');
    }

    public function test_agent_can_only_see_tickets_assigned_to_him_in_tickets_table()
    {
        $user = User::factory()->create();
        $agent = User::factory()->create(['role_id' => Role::AGENT_ID]);
        $agent2 = User::factory()->create(['role_id' => Role::AGENT_ID]);
        $ticket = Ticket::factory()->create(['assigned_to' => $agent2->id]);

        $response = $this->actingAs($agent)->get('/tickets');
        
        $response->assertStatus(200);
        $response->assertDontSee($ticket->title);
    }

    public function test_agent_can_access_edit_page_for_tickets_assigned_to_him()
    {
        $user = User::factory()->create();
        $agent = User::factory()->create(['role_id' => Role::AGENT_ID]);
        $ticket = Ticket::factory()->create(['assigned_to' => $agent->id]);

        $response = $this->actingAs($agent)->get('/tickets/' . $ticket->id . '/edit');
        
        $response->assertSee('value="' . $ticket->title . '"', false);
        $response->assertSeeText($ticket->message);
        $response->assertStatus(200);
    }

    public function test_agent_cannot_view_the_edit_page_for_tickets_not_assigned_to_him()
    {
        $user = User::factory()->create();
        $agent = User::factory()->create(['role_id' => Role::AGENT_ID]);
        $agent2 = User::factory()->create(['role_id' => Role::AGENT_ID]);
        $ticket = Ticket::factory()->create(['assigned_to' => $agent2->id]);

        $response = $this->actingAs($agent)->get('/tickets/' . $ticket->id . '/edit');
        
        $response->assertStatus(404);
    }

    public function test_agent_cannot_update_tickets_not_assigned_to_him()
    {
        $user = User::factory()->create();
        $agent = User::factory()->create(['role_id' => Role::AGENT_ID]);
        $agent2 = User::factory()->create(['role_id' => Role::AGENT_ID]);
        $ticket = Ticket::factory()->create(['assigned_to' => $agent2->id]);

        $response = $this->actingAs($agent)->put('/tickets/' . $ticket->id, [
            'title' => 'test title',
            'message' => 'test message',
            'categories' => [1, 2],
            'labels' => [1],
        ]);
        
        $response->assertStatus(404);
    }

    public function test_agent_can_update_tickets_assigned_to_him_and_no_validation_errors()
    {
        $user = User::factory()->create();
        $agent = User::factory()->create(['role_id' => Role::AGENT_ID]);
        $ticket = Ticket::factory()->create(['assigned_to' => $agent->id]);

        $response = $this->actingAs($agent)->put('/tickets/' . $ticket->id, [
            'title' => 'test title',
            'message' => 'test message',
            'categories' => [1, 2],
            'labels' => [1],
        ]);
        
        $response->assertStatus(302);
        $response->assertSessionHasNoErrors();
    }

    public function test_agent_can_update_tickets_assigned_to_him_and_has_validation_errors()
    {
        $user = User::factory()->create();
        $agent = User::factory()->create(['role_id' => Role::AGENT_ID]);
        $ticket = Ticket::factory()->create(['assigned_to' => $agent->id]);

        $response = $this->actingAs($agent)->put('/tickets/' . $ticket->id, [
            'title' => '',
            'message' => '',
            'categories' => [],
            'labels' => [],
        ]);
        
        $response->assertStatus(302);
        $response->assertInvalid(['title','message','categories','labels']);
    }

    public function test_agent_cannot_see_delete_button_in_tickets_page()
    {
        $user = User::factory()->create();
        $agent = User::factory()->create(['role_id' => Role::AGENT_ID]);
        $ticket = Ticket::factory()->create(['assigned_to' => $agent->id]);

        $response = $this->actingAs($agent)->get('/tickets');
        
        $response->assertStatus(200);
        $response->assertDontSee('Delete');
    }

    public function test_admin_can_see_edit_button_in_tickets_page()
    {
        $user = User::factory()->create();
        $admin = User::factory()->create(['role_id' => Role::ADMIN_ID]);
        $ticket = Ticket::factory()->create();

        $response = $this->actingAs($admin)->get('/tickets');
        
        $response->assertStatus(200);
        $response->assertSee('Edit');
    }

    public function test_admin_can_see_delete_button_in_tickets_page()
    {
        $user = User::factory()->create();
        $admin = User::factory()->create(['role_id' => Role::ADMIN_ID]);
        $ticket = Ticket::factory()->create();

        $response = $this->actingAs($admin)->get('/tickets');
        
        $response->assertStatus(200);
        $response->assertSee('Delete');
    }

    public function test_admin_can_delete_any_ticket()
    {
        $user = User::factory()->create();
        $admin = User::factory()->create(['role_id' => Role::ADMIN_ID]);
        $ticket = Ticket::factory()->create();

        $response = $this->actingAs($admin)->delete('tickets/' . $ticket->id);

        $response->assertStatus(302);
        $this->assertDatabaseMissing('tickets', $ticket->toArray());
        $this->assertDatabaseCount('tickets', 0);
    }

    public function test_user_can_upload_file()
    {
        Storage::fake('public');
        $user = User::factory()->create();
        $fileUpload = UploadedFile::fake()->image('avatar.jpg');

        $response = $this->actingAs($user)->post('/tickets', [
            'title' => 'test title',
            'message' => 'test message',
            'priority' => 'low',
            'upload' => $fileUpload,
            'labels' => [1],
            'categories' => [1],
        ]);

        $ticket = Ticket::latest()->first();
        $this->assertEquals($fileUpload->hashName(), $ticket->upload);
        Storage::disk('public')->assertExists('uploads/' . $user->id . '/'. $fileUpload->hashName());
    }
}
