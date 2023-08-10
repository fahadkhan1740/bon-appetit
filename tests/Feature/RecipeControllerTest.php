<?php

namespace Tests\Feature;

use App\Models\Ingredients;
use App\Models\Recipe;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecipeControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_lists_recipes(): void
    {
        Recipe::factory()->count(5)->create();

        $response = $this->getJson('/api/recipes')->assertSuccessful();

        $this->assertCount(5, $response->json('data')['data']);
        $this->assertEquals(5, $response->json('data')['total']);
    }

    /** @test */
    public function it_creates_an_recipe(): void
    {
        $ingredients = Ingredients::factory()->count(3)->create();

        $this->postJson('/api/recipes', [
            'name' => 'Tea',
            'description' => 'This is a Karak tea',
            'ingredients' => [
                ['id' => $ingredients[0]->id, 'amount' => '10'],
                ['id' => $ingredients[1]->id, 'amount' => '1'],
                ['id' => $ingredients[2]->id, 'amount' => '20']
            ]
        ])
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'name' => 'Tea',
                    'description' => 'This is a Karak tea',
                    'ingredients' => [
                        [
                            'id' => $ingredients[0]->id,
                            'pivot' => [
                                'amount' => '10'
                            ]
                        ],
                        [
                            'id' => $ingredients[1]->id,
                            'pivot' => [
                                'amount' => '1'
                            ],
                        ],
                        [
                            'id' => $ingredients[2]->id,
                            'pivot' => [
                                'amount' => '20'
                            ],
                        ]
                    ]
                ]
            ]);
    }
}
