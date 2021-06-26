<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class PlanSubscriber extends Model
{
    use HasFactory;

    protected $table = 'plan_subscriber';

    protected $fillable = [
        'plan_remaining',
        'begin_date',
        'expiry_date',
        'plan_id',
        'subscriber_id'
    ];
}
