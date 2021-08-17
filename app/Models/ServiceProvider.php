<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceProvider extends Model
{
    use HasFactory, SoftDeletes;

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
    public function receptionists()
    {
        return $this->belongsToMany(User::class, 'service_provider_user');
    }
}
