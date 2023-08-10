<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static paginate()
 * @method static create(array $all)
 */
class Ingredients extends Model
{
    use HasFactory;

    protected $guarded = [];
}
