<?php

namespace App\Models;

use App\Models\Concerns\HasSlug;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceLimitGroupCalculationType extends Model
{
    use HasFactory, HasSlug, SoftDeletes;

    protected $fillable = [
        'name',
        'slug'
    ];

    public function planService()
    {
        return $this->hasMany(PlanService::class, "limit_group_calculation_type_id");
    }
}
