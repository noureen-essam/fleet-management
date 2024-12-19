<?php

namespace Tests\Feature;

use App\Models\Line;
use App\Models\LineStations;
use App\Models\Stations;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GetAvailableLinesTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_available_lines_successfully_returns_matching_lines()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $stationA = Stations::factory()->create();
        $stationB = Stations::factory()->create();

        // Create a line with the factory
        $line = Line::factory()->create();

        // Associate stations with the line
        LineStations::factory()->create([
            'line_id' => $line->id,
            'station_id' => $stationA->id,
            'stop_order' => 1,
        ]);

        LineStations::factory()->create([
            'line_id' => $line->id,
            'station_id' => $stationB->id,
            'stop_order' => 2,
        ]);

        $response = $this->postJson('/get-available-lines', [
            'start_station' => $stationA->id,
            'end_station' => $stationB->id,
        ]);

        $response->assertStatus(200);
        $response->assertJsonFragment([
            'id' => $line->id,
        ]);
    }

    public function test_get_available_lines_fails_with_invalid_station_ids()
    {
        $user = User::factory()->create();
        $this->actingAs($user);
        
        $response = $this->postJson('/get-available-lines', [
            'start_station' => 999,
            'end_station' => 888,
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['start_station', 'end_station']);
    }
}
