<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBoxRequest;
use App\Http\Requests\UpdateBoxRequest;
use App\Models\Box;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class BoxController extends Controller
{
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
