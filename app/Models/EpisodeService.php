<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class EpisodeService extends Pivot
{
    use HasFactory, SoftDeletes;

    protected $table = 'episode_service';

    protected $fillable = [
        'service_id',
        'episode_id',
        'insurance_covered_limit',
        'aasandha_covered_limit',
        'self_covered_limit'
    ];
    
}
