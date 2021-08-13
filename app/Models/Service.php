<?php

namespace App\Models;

use App\Models\Plan;
use App\Models\Episode;
use App\Models\Subscriber;
use App\Models\ServiceType;
use App\Models\ServiceLimitGroup;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class Service extends Model
{
    use HasFactory, SoftDeletes;

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
        return $this->belongsToMany(Episode::class, 'episode_service', 'service_id', 'episode_id');
    }

    public function plans() : BelongsToMany{
        return $this->belongsToMany(Plan::class, 'plan_service', 'service_id', 'plan_id')->withPivot('limit_total', 'limit_group_calculation_type_id')->join('service_limit_group_calculation_types', 'limit_group_calculation_type_id', 'service_limit_group_calculation_types.id')->select('service_limit_group_calculation_types.slug as pivot_limit_calculator', 'plans.*');
    }

    public function planServiceLimitGroup()
    {        
        return $this->hasManyThrough(ServiceLimitGroup::class, Plan::class);
    }

    public function serviceType() : BelongsTo{
        return $this->belongsTo(ServiceType::class);
    }

    public function serviceLimitGroup() : BelongsTo{
        return $this->belongsTo(ServiceLimitGroup::class, 'service_limit_group_id');
    }

    public function serviceLimitGroupCalculationType() : HasOneThrough{
        return $this->hasOneThrough(ServiceLimitGroupCalculationType::class, PlanService::class, 'limit_group_calculation_type_id');
    }

    // public function serviceLimitGroupLimit()
    // {
    //     return $this->hasManyThrough(PlanServiceLimitGroup::class, PlanService::class, );
    // }

    // public function subscribers() : BelongsToMany{
    //     return $this->belongsToMany(Subscriber::class, 'service_subscriber')->using(ServiceSubscriber::class)->withPivot(['subscriber_id', 'service_id', 'covered_limit', 'activity_at']);
    // }
}
