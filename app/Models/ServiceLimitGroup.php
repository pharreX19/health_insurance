<?php

namespace App\Models;

use App\Models\Service;
use App\Models\Concerns\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Services\LimitCalculators\AnnualCalculator;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ServiceLimitGroup extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        "title",
        "description",
        "limit_total",
        "slug"
    ];

    protected $limitCalculators = [
        "annual" => AnnualCalculator::class
    ];

    public function limitCalculator(String $slug, $service, $subscription){
        if(!in_array($slug, array_keys($this->limitCalculators))){
            return true;
        }
        return (new $this->limitCalculators[$slug]($service, $subscription))->isServiceReceiveable();  
    }

    public function services() : HasMany{
        return $this->hasMany(Service::class);
    }

    public function plans() : BelongsToMany{
        return $this->belongsToMany(Plan::class, 'plan_service_limit_group')->withPivot('limit_total');
    }
}
