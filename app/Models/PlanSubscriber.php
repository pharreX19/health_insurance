<?php

// namespace App\Models;

// use Carbon\Carbon;
// use Illuminate\Database\Eloquent\Factories\HasFactory;
// use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\Relations\Pivot;
// use Illuminate\Database\Eloquent\SoftDeletes;

// class PlanSubscriber extends Pivot
// {
    // use HasFactory, SoftDeletes;
    
    // protected $table = 'plan_subscriber';

    // protected $fillable = [
    //     'plan_remaining',
    //     'begin_date',
    //     'expiry_date',
    //     'plan_id',
    //     'subscriber_id'
    // ];

    // protected $dates = [
    //     "begin_date",
    //     "expiry_date"
    // ];

//     public static function boot(){
//         static::creating(function(Model $model){
//             $model->updated_at = Carbon::now();
//         });
//     }
// }
