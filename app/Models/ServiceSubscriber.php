<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceSubscriber extends Pivot
{
    use HasFactory, SoftDeletes;

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
