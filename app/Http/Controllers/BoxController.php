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
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBoxRequest $request): JsonResponse
    {
        $box = Box::create($request->only('delivery_date'));

        return response()->json([
            'data' => $box
        ], Response::HTTP_CREATED);
    }
}
