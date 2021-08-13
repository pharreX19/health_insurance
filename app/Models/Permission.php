<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permission extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'permissions';

    protected $fillable = [
        'name',
        'description',
        'slug'
    ];
    
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permission_role');
    }
}
