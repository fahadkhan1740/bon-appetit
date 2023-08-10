<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BoxControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_a_new_box(): void
    {
        $futureDate = now()->addDay()->format('Y-m-d');

        $this->postJson('/api/box', [
            'delivery_date' => $futureDate
        ])
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'delivery_date' => $futureDate
                ]
            ]);
    }
}
