<?php

namespace Tests\Feature;

use App\Models\Recipe;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BoxControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_creates_a_new_box(): void
    {
        $recipes = Recipe::factory()->count(4)->state(
            new Sequence(
                ['id' => 100],
                ['id' => 200],
                ['id' => 300],
                ['id' => 400]
            )
        )->create();

        $futureDate = now()->addDay()->format('Y-m-d');

        $this->postJson('/api/box', [
            'delivery_date' => $futureDate,
            'recipes' => [
                ['id' => $recipes[0]->id],
                ['id' => $recipes[1]->id],
                ['id' => $recipes[2]->id],
                ['id' => $recipes[3]->id]
            ]
        ])
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'delivery_date' => $futureDate,
                    'recipes' => [
                        ['id' => $recipes[0]->id],
                        ['id' => $recipes[1]->id],
                        ['id' => $recipes[2]->id]
                    ]
                ]
            ]);
    }
}
