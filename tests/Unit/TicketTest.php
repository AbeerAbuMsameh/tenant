<?php
use Tests\TestCase;
use App\Models\Ticket;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TicketTest extends TestCase
{
    use RefreshDatabase;

    public function testStoreTicket()
    {
        // Arrange: Prepare the necessary data and mocking
        $data = [
            'ticket_num' => 'T001',
            'report_src' => 'Email',
            'impact' => 'Limited',
            'description' => 'Test ticket',
        ];
        $response = $this->post('/home/company/tickets', $data);

        $response->assertStatus(200);
        $response->assertViewIs('tickets.index');
        $response->assertSee('Ticket Created Successfully!');
        $this->assertDatabaseHas('tickets', $data);
    }


}
