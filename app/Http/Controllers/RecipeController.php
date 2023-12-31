<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRecipeRequest;
use App\Models\Ingredients;
use App\Models\Recipe;
use Illuminate\Http\JsonResponse;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $data = QueryBuilder::for(Recipe::class)
            ->with('ingredients')
            ->paginate();

        return response()->json([
            'data' => $data
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRecipeRequest $request): JsonResponse
    {
        $recipe = Recipe::create($request->except('ingredients'));

        foreach ($request->only('ingredients')['ingredients'] as $ingredient) {
            $recipe->ingredients()->attach($ingredient['id'], ['amount' => $ingredient['amount']]);
        }

        return response()->json([
                'data' => $recipe->load('ingredients')
        ], Response::HTTP_CREATED);
    }
}
