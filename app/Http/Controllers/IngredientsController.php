<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIngredientRequest;
use App\Models\Ingredients;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;

class IngredientsController extends Controller
{
    /**
     * Lists all the ingredients
     */
    public function index(): JsonResponse
    {
        $data = QueryBuilder::for(Ingredients::class)
            ->allowedFilters('supplier')
            ->paginate();

        return response()->json([
            'data' => $data
        ], Response::HTTP_OK);
    }

    /**
     * Creates a new ingredient
     */
    public function store(StoreIngredientRequest $request): JsonResponse
    {
        $ingredient = Ingredients::create($request->all());

        return response()->json([
            'data' => $ingredient
        ], Response::HTTP_CREATED);
    }
}
