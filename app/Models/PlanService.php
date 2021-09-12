<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlanService extends Pivot
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['limit_total'];

    protected $table = 'plan_service';

    protected $casts = [
        "limit_total" => "double"
    ];

    public function calculationType()
    {
        return $this->belongsTo(ServiceLimitGroupCalculationType::class, "limit_group_calculation_type_id");
    }
}
