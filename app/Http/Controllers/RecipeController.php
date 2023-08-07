<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRecipeRequest;
use App\Models\Recipe;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class RecipeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        return response()->json([
                'data' => Recipe::paginate()
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRecipeRequest $request): JsonResponse
    {
        $recipe = Recipe::create($request->except('ingredients'));

        return response()->json([
                'data' => $recipe
        ], Response::HTTP_CREATED);
    }
}
