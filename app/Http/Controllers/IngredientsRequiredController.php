<?php

namespace App\Http\Controllers;

use App\Http\Requests\IngredientsRequiredListFormRequest;
use App\Models\Box;
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
        $boxes = Box::whereDate('created_at', $request->input('order_date'))
            ->with('recipes.ingredients')
            ->get();

        $ingredients = $boxes->pluck('recipes.*.ingredients')->flatten(2);

        $ingredientsRequired = $ingredients->groupBy(function ($item) {
            return $item['id'] . '_' . $item['name'];
        })->map(function ($groupedItems) {
            $totalAmount = $groupedItems->sum('pivot.amount');
            $firstItem = $groupedItems->first();

            return [
                'id' => $firstItem['id'],
                'name' => $firstItem['name'],
                'amount' => $totalAmount,
            ];
        })->values();

        return response()->json([
            'data' => $ingredientsRequired
        ], Response::HTTP_OK);
    }
}
