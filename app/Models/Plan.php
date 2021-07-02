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
        'currency',
        'policy_id'
    ];

    protected $casts = [
        "limit_total" => "float"
    ];

    public function policy() : BelongsTo{
        return $this->belongsTo(Policy::class);
    }


    public function subscriptions() : HasMany{
        return $this->hasMany(Subscription::class);
    }

    public function services() : BelongsToMany{
        return $this->belongsToMany(Service::class, 'plan_service')->withPivot('limit_total');
    }

    public function subscribers() : HasMany{
        return $this->hasMany(Subscriber::class);
        //->using(PlanSubscriber::class)->withPivot(['id', 'plan_remaining','begin_date', 'expiry_date']);
    }

    public function servicelimitGroups() : BelongsToMany{
        return $this->belongsToMany(Plan::class, 'plan_service_limit_group')->withPivot('limit_total');
    }

}

