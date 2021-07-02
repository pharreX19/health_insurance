<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class ServiceSubscriber extends Pivot
{
    use HasFactory;

    protected $table = 'service_subscriber';

    protected $dates = [
        "activity_at"
    ];

    protected $casts = [
        "covered_limit" => "float"
    ];

    public static function boot(){
        parent::boot();
        static::creating(function($model){
            $model->activity_at = Carbon::now()->toDateString();
        });
    }
}
