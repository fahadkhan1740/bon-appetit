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

    /** @test */
    public function it_validates_creating_a_recipe(): void
    {
        $this->postJson('/api/recipes', [
            'name' => 123456780,
            'description' => 'km',
            'ingredients' => 21324354675
        ])
            ->assertUnprocessable()
            ->assertJsonFragment([
                'name' => ['The name field must be a string.'],
                'description' => ['The description field must be at least 10 characters.'],
                'ingredients' => ['The ingredients field must be an array.']
            ]);

        $this->postJson('/api/recipes', [
            'name' => '',
            'description' => '',
            'ingredients' => ''
        ])
            ->assertUnprocessable()
            ->assertJsonFragment([
                'name' => ['The name field is required.'],
                'description' => ['The description field is required.'],
                'ingredients' => ['The ingredients field is required.']
            ]);

        $this->postJson('/api/recipes', [
            'name' => 'foobar',
            'description' => 'This is a foodbar recipe',
            'ingredients' => [
                ['id' => 'random-id', 'amount' => 'too-much']
            ]
        ])
            ->assertUnprocessable()
            ->assertJsonFragment([
                'ingredients.0.id' => ['The selected ingredients.0.id is invalid.'],
                'ingredients.0.amount' => ['The ingredients.0.amount field must be a number.']
            ]);
    }
}
