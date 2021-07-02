<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceProvider extends Model
{
    use HasFactory;

    protected $fillable =[
        'name',
        'contact',
        'address',
        'street'
    ];

    public function episodes()
    {
        return $this->hasMany(Episode::class);
    }

    public function claims(){
        return $this->hasManyThrough(EpisodeService::class, Episode::class, 'service_provider_id', 'episode_id');
    }

    // public function claims()
    // {
    //     return $this->hasMany(Claim::class);
    // }
}
