<?php

namespace App\Models;

use App\Http\Traits\PolicyNumber;
use App\Models\Plan;
use App\Models\Company;
use App\Models\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

class Subscriber extends Model
{
    use HasFactory, SoftDeletes, PolicyNumber;

    protected $fillable = [
        "name",
        "passport",
        "work_permit",
        "national_id",
        "policy_number",
        "country",
        "contact",
        "company_id",
        'plan_id'
    ];

    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }


    public function plan() : BelongsTo{
        return $this->belongsTo(Plan::class);
        //  'plan_subscriber')->using(PlanSubscriber::class)->withPivot(["begin_date", "expiry_date", "plan_remaining"])->withTimestamps()->orderByPivot("created_at", "desc");
    }

    public function subscriptions() : HasMany{
        return $this->hasMany(Subscription::class);
    }

    // public function services() : BelongsToMany{
    //     return $this->belongsToMany(Service::class, 'service_subscriber')->using(ServiceSubscriber::class)->withPivot(['subscriber_id', 'service_id', 'covered_limit', 'activity_at']);
    // }

    public function company() : BelongsTo{
        return $this->belongsTo(Company::class);
    }

    public function getPolicyNumberAttribute($value){
        return str_replace("_", "", $value);
    }

    public function getPaymentMethodAttribute($value)
    {
        return str_replace('_', ' ', $value);
    }
}
