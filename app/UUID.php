<?php

namespace App;

use Illuminate\Support\Str;

trait UUID
{
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->id = $model->id ?: Str::orderedUuid()->toString();
        });
    }
}
