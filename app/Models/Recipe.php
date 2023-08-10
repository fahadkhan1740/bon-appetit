<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Recipe extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function ingredients(): BelongsToMany
    {
        return $this->belongsToMany(Ingredients::class, 'recipe_ingredients', 'recipe_id', 'ingredient_id')
            ->withPivot('amount');
    }
}
