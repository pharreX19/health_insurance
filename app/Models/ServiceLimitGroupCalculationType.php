<?php

namespace App\Models;

use App\Models\Concerns\HasSlug;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceLimitGroupCalculationType extends Model
{
    use HasFactory, HasSlug;

    protected $fillable = [
        'name',
        'slug'
    ];

    public function planService()
    {
        return $this->hasMany(PlanService::class, "limit_group_calculation_type_id");
    }
}
