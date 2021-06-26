<?php

namespace App\Traits;

trait Child{
    public static function boot(){
        parent::boot();
        static::creating(function($user){
            $user->forceFill([
                'user_type' => static::class
            ]);
        });
    }

    public static function booted()
    {
        static::addGlobalScope(static::class, function($query){
            return $query->where('user_type', static::class);
        });
    }
}