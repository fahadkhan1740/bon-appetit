<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBoxRequest;
use App\Models\Box;
use App\Models\Ingredients;
use Illuminate\Http\JsonResponse;
use Spatie\QueryBuilder\QueryBuilder;
use Symfony\Component\HttpFoundation\Response;

class BoxController extends Controller
{
    /**
     * Lists all the boxes
     */
    public function index(): JsonResponse
    {
        $data = QueryBuilder::for(Box::class)
            ->allowedFilters('delivery_date')
            ->paginate();

        return response()->json([
            'data' => $data
        ], Response::HTTP_OK);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBoxRequest $request): JsonResponse
    {
        $box = Box::create($request->only('delivery_date'));

        $box->recipes()->attach(array_column($request->input('recipes'), 'id'));

        return response()->json([
            'data' => $box->load('recipes')
        ], Response::HTTP_CREATED);
    }
}
