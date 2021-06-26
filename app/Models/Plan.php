<?php

namespace App\Models;

use App\Models\Service;
use App\Models\Subscriber;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'limit_total',
        'currency'
    ];

    public function services() : BelongsToMany{
        return $this->belongsToMany(Service::class, 'plan_service')->withPivot('limit_total');
    }

    public function subscribers() : BelongsToMany{
        return $this->belongsToMany(Subscriber::class, 'plan_subscriber')->withPivot(['id', 'plan_remaining','begin_date', 'expiry_date']);
    }

    protected $dates = [
        'begin_date',
        'expiry_date'
    ];

}

