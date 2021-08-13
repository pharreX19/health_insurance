<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PlanServiceLimitGroup extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = "plan_service_limit_group";
}
