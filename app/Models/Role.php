<?php

namespace App\Models;

use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class Role extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name'
    ];

    public static function boot()
    {
        parent::boot();
        static::deleting(function($model){
            if($model->id === 1){
                throw ValidationException::withMessages([
                    "message" => "Cannot delete admin user role."
                ]);
            }
        });
    }
    
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role');
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function hasPermission(Role $role, Permission $permission)
    {
        return $this->whereHas('permissions', function($query) use($permission){
            $query->where('slug', $permission->slug);
        })->where('name', $role->name)->exists();
    }

    public function grantPermission(Permission $permission)
    {
        $this->permissions()->attach($permission);
    }
    
    public function revokePermission(Permission $permission)
    {
        // dd($this->role->permissions());
        $this->permissions()->detach($permission);
    }
}
