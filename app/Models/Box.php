<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method static create(array $only)
 * @method static whereDate(string $string, mixed $input)
 */
class Box extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function recipes(): BelongsToMany
    {
        return $this->belongsToMany(Recipe::class, 'box_recipes', 'box_id', 'recipe_id');
    }
}
