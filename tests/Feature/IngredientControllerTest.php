<?php

namespace Tests\Feature;

use App\Models\Ingredients;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IngredientControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_lists_ingredients(): void
    {
        Ingredients::factory()->count(5)->create();

        $response = $this->getJson('/api/ingredients')->assertSuccessful();

        $this->assertCount(5, $response->json('data')['data']);
        $this->assertEquals(5, $response->json('data')['total']);
    }

    /** @test */
    public function it_creates_an_ingredient(): void
    {
        $this->postJson('/api/ingredients', [
            'name' => 'Sugar',
            'measure' => 'g',
            'supplier' => 'lulu'
        ])
            ->assertSuccessful()
            ->assertJson([
                'data' => [
                    'name' => 'Sugar',
                    'measure' => 'g',
                    'supplier' => 'lulu'
                ]
            ]);
    }

    /** @test */
    public function it_validates_creating_an_ingredient(): void
    {
        $this->postJson('/api/ingredients', [
            'name' => 123456780,
            'measure' => 'km',
            'supplier' => 21324354675
        ])
            ->assertUnprocessable()
            ->assertJsonFragment([
                'name' => ['The name field must be a string.'],
                'measure' => ['The selected measure is invalid.'],
                'supplier' => ['The supplier field must be a string.']
            ]);

        $this->postJson('/api/ingredients', [
            'name' => '',
            'measure' => '',
            'supplier' => ''
        ])
            ->assertUnprocessable()
            ->assertJsonFragment([
                'name' => ['The name field is required.'],
                'measure' => ['The measure field is required.'],
                'supplier' => ['The supplier field is required.']
            ]);
    }
}
