<?php

namespace App\Http\Controllers;

use App\Models\Ingredients;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IngredientsController extends Controller
{
    /**
     * Lists all the ingredients
     */
    public function index(): JsonResponse
    {
        return response()->json([
            'data' => Ingredients::paginate()
        ], Response::HTTP_OK);
    }

    /**
     * Creates a new ingredient
     */
    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'name' => ['required', 'min:2', 'max:255', 'string'],
            'measure' => ['required', 'string', 'in:g,kg,pieces'],
            'supplier' => ['required', 'min:2', 'max:255', 'string'],
        ]);

        $ingredient = Ingredients::create($request->all());

        return response()->json([
            'data' => $ingredient
        ], Response::HTTP_CREATED);
    }
}
