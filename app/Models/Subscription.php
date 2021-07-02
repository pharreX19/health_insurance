<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        "plan_id",
        "subscriber_id",
        "plan_remaining",
        "begin_date",
        "expiry_date",
        "is_active"
    ];

    protected $dates = [
        'begin_date',
        'expiry_date'
    ];

    public function plan() : BelongsTo{
        return $this->belongsTo(Plan::class);
    }

    public function subscriber() : BelongsTo{
        return $this->belongsTo(Subscriber::class);
    }
    
    public static function boot(){
        parent::boot();
        static::creating(function($model){
            $model->expiry_date = Carbon::now()->addYear(1)->toDateString();
        });

        static::addGlobalScope('active-subscriptions', function($query){
            return $query->where('is_active', true);
        });
    }

}
