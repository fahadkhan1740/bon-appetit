<?php

namespace App\Http\Controllers;

use App\Http\Requests\IngredientsRequiredListFormRequest;
use App\Models\Ingredients;
use Illuminate\Http\JsonResponse;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;

class IngredientsRequiredController extends Controller
{
    /**
     * Lists all the ingredients required
     */
    public function index(IngredientsRequiredListFormRequest $request): JsonResponse
    {
        

        return response()->json([

        ], Response::HTTP_OK);
    }
}
