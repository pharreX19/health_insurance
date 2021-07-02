<?php

namespace App\Models;

use App\Models\Plan;
use App\Models\Episode;
use App\Models\Subscriber;
use App\Models\ServiceType;
use App\Models\ServiceLimitGroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "description",
        "service_type_id",
        "service_limit_group_id"
    ];

    // public function episodes()
    // {
    //     return $this->hasMany(Episode::class);
    // }

    public function episodes()
    {
        return $this->belongsToMany(Episode::class, 'episode_service', 'episode_id');
    }

    public function plans() : BelongsToMany{
        return $this->belongsToMany(Plan::class, 'plan_service')->withPivot('limit_total');
    }

    public function serviceType() : BelongsTo{
        return $this->belongsTo(ServiceType::class);
    }

    public function serviceLimitGroup() : BelongsTo{
        return $this->belongsTo(ServiceLimitGroup::class, 'service_limit_group_id');
    }

    // public function subscribers() : BelongsToMany{
    //     return $this->belongsToMany(Subscriber::class, 'service_subscriber')->using(ServiceSubscriber::class)->withPivot(['subscriber_id', 'service_id', 'covered_limit', 'activity_at']);
    // }
}
