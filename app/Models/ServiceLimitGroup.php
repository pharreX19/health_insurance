<?php

namespace App\Models;

use App\Models\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Http\Services\LimitCalculators\EventLimitCalculator;
use App\Http\Services\LimitCalculators\AnnualLimitCalculator;

class ServiceLimitGroup extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        "name",
        "description",
        // "limit_total",
        // "slug"
    ];

    protected $limitCalculators = [
        "per-day" => AnnualLimitCalculator::class,
        "per_month" => AnnualLimitCalculator::class,
        "per-year" => AnnualLimitCalculator::class,
        "per-event" => EventLimitCalculator::class,
    ];

    public function limitCalculator(String $slug, $service, $subscription){
        
        if(!in_array($slug, array_keys($this->limitCalculators))){
            return true;
        }
        return (new $this->limitCalculators[$slug]($service, $subscription))->serviceCoverableLimit();  
    }

    public function services() : HasMany{
        return $this->hasMany(Service::class);
    }

    public function plans() : BelongsToMany{
        return $this->belongsToMany(Plan::class, 'plan_service_limit_group')->withPivot('limit_total');
    }
}
