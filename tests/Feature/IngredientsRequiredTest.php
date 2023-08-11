<?php

namespace Tests\Feature;

use App\Models\Box;
use App\Models\Ingredients;
use App\Models\Recipe;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class IngredientsRequiredTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_filters_ingredients_required_by_order_date(): void
    {
        // create ingredients
        $ingredients = Ingredients::factory()->count(3)->state(
            new Sequence(
                ['name' => 'egg', 'measure' => 'pieces', 'amount' => 10],
                ['name' => 'bread', 'measure' => 'pieces', 'amount' => 10],
                ['name' => 'butter', 'measure' => 'g', 'amount' => 1000]
            )
        )->create();

        // create recipes
        $recipe = Recipe::factory()->create();

        $recipe->ingredients()->attach($ingredients[0]['id'], ['amount' => 2]);
        $recipe->ingredients()->attach($ingredients[1]['id'], ['amount' => 4]);
        $recipe->ingredients()->attach($ingredients[2]['id'], ['amount' => 100]);

        // create boxes
        $futureDate = now()->addDays(3)->format('Y-m-d');

        $this->postJson('/api/box', [
            'delivery_date' => $futureDate,
            'recipes' => [
                ['id' => $recipe->id],
            ]
        ])
            ->assertSuccessful();

        $orderDate = today()->format('Y-m-d');

        $response = $this->getJson('/api/ingredients-required?order_date=' . $orderDate)->assertSuccessful();

        $this->assertCount(3, $response->json('data')['data']);
        $this->assertEquals(8, $response->json('data')['data'][0]['amount']);
        $this->assertEquals(6, $response->json('data')['data'][1]['amount']);
        $this->assertEquals(900, $response->json('data')['data'][2]['amount']);
    }
}
