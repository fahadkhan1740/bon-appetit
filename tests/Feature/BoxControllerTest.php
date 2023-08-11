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

        $futureDate = now()->addDays(3)->format('Y-m-d');

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

    /** @test */
    public function it_validates_creating_a_box(): void
    {
        $this->postJson('/api/box', [
            'delivery_date' => '2023-01-01',
            'recipes' => [['id' => Recipe::factory()->create()->id]]
        ])
            ->assertUnprocessable()
            ->assertJsonFragment([
                'delivery_date' => [
                    'The delivery date must be beyond 48 hours.',
                ],
            ]);

        $this->postJson('/api/box', [
            'delivery_date' => '',
            'recipes' => '',
        ])
            ->assertUnprocessable()
            ->assertJsonFragment([
                'delivery_date' => ['The delivery date field is required.'],
                'recipes' => ['The recipes field is required.']
            ]);

        $this->postJson('/api/box', [
            'delivery_date' => now()->addDays(5)->format('Y-m-d'),
            'recipes' => [
                ['id' => 'random-id']
            ]
        ])
            ->assertUnprocessable()
            ->assertJsonFragment([
                'recipes.0.id' => ['The selected recipes.0.id is invalid.']
            ]);
    }
}
