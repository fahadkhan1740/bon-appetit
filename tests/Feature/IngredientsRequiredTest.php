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
        $ingredients = Ingredients::factory()->count(3)->state(
            new Sequence(
                ['name' => 'egg', 'measure' => 'pieces'],
                ['name' => 'bread', 'measure' => 'pieces'],
                ['name' => 'butter', 'measure' => 'g']
            )
        )->create();

        $recipe = Recipe::factory()->create();

        $recipe->ingredients()->attach($ingredients[0]['id'], ['amount' => 2]);
        $recipe->ingredients()->attach($ingredients[1]['id'], ['amount' => 4]);
        $recipe->ingredients()->attach($ingredients[2]['id'], ['amount' => 100]);

        $futureDate = now()->addDays(3)->format('Y-m-d');

        $box = Box::factory()->create(['delivery_date' => $futureDate]);
        $box->recipes()->attach($recipe);

        $orderDate = today()->format('Y-m-d');

        $response = $this->getJson('/api/ingredients-required?order_date=' . $orderDate)->assertSuccessful();

        $this->assertCount(3, $response->json('data'));
        $this->assertEquals(2, $response->json('data')[0]['amount']);
        $this->assertEquals(4, $response->json('data')[1]['amount']);
        $this->assertEquals(100, $response->json('data')[2]['amount']);
    }
}
