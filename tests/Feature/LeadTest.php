<?php

namespace Tests\Feature;

use App\Enums\CallResultEnum;
use App\Models\Call;
use App\Models\Lead;
use App\Models\Manager;
use Illuminate\Foundation\Testing\DatabaseTransactions;

use Tests\TestCase;

class LeadTest extends TestCase
{
    use DatabaseTransactions;

    public function test_to_create_new_lead()
    {

        $incorrectPayload = [
            'name' => 'John Doe',
            'phone' => ''
        ];
        $this->postJson('/api/leads', $incorrectPayload)
            ->assertUnprocessable()
            ->assertJsonPath('errors.phone.0', 'The phone field is required.');


        $payload = [
            'name' => 'John Doe',
            'phone' => '380501234567',
        ];

        $this->postJson('/api/leads', $payload)
            ->assertCreated()
            ->assertJson([
                'success' => true,
                'lead' => [
                    'name' => 'John Doe',
                    'status' => 'new',
                    'manager_id' => null,
                ]
            ]);
        $this->assertDatabaseHas('leads', [
            'name' => 'John Doe',
            'phone' => '380501234567',
            'manager_id' => null
        ]);
    }

    public function test_to_see_leads_of_each_manager_with_pagination()
    {
        $manager = Manager::factory()->create();

        $leads = Lead::factory(20)->create([
            'manager_id' => $manager->id,
        ]);

        foreach ($leads as $lead) {
            Call::factory(3)->create([
                'lead_id' => $lead->id,
                'duration' => 10,
                'result' => CallResultEnum::NO_ANSWER,
            ]);
        }

        $response = $this
            ->getJson("/api/managers/{$manager->id}/leads")
            ->assertOk()
            ->assertJsonCount(16, 'data');

        $json = $response->json();

        $firstLead = $json['data'][0];


        $this->assertArrayHasKey('id', $firstLead);
        $this->assertArrayHasKey('name', $firstLead);
        $this->assertArrayHasKey('status', $firstLead);
        $this->assertArrayHasKey('calls_count', $firstLead);
        $this->assertArrayHasKey('total_call_duration', $firstLead);

        $this->assertEquals(3, $firstLead['calls_count']);
        $this->assertEquals(30, $firstLead['total_call_duration']);
    }

    public function test_manager_with_no_leads_returns_empty_data()
    {
        $manager = Manager::factory()->create();

        $this->getJson("/api/managers/{$manager->id}/leads")
            ->assertOk()
            ->assertJson([
                'data' => []
            ]);


    }
}
