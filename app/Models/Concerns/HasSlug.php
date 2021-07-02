<?php

namespace App\Models\Concerns;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

trait HasSlug{
    public static function bootHasSlug(){
        static::creating(function(Model $model){
            $model->slug = Str::slug($model->name);
        });
    }
}