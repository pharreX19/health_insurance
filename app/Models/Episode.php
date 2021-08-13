<?php

namespace App\Models;

use App\Models\Service;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Episode extends Pivot
{
    use HasFactory, SoftDeletes;
    protected $table = "episodes";

    public $incrementing = true;

    protected $fillable = [
        'memo_number',
        'subscriber_id',
        'service_provider_id'
    ];

    public static function boot(){
        parent::boot();
        static::creating(function($model){
            $model->activity_at = Carbon::now()->toDateString();
        });
    }

    public function subscriber()
    {
        return $this->belongsTo(Subscriber::class);
    }


    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'episode_service', 'episode_id')->withPivot('id', 'service_id', 'insurance_covered_limit', 'aasandha_covered_limit', 'self_covered_limit')->where('episode_service.deleted_at', null );
    }


    public function serviceProvider()
    {
        return $this->belongsTo(ServiceProvider::class);
    }
    
}
