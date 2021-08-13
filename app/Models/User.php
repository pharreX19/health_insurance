<?php

namespace App\Models;

use App\Models\Role;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use phpDocumentor\Reflection\Types\Boolean;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'email_verified_at',
        'gender',
        'contact',
        'service_provider_id',
        'role_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'active' => 'boolean'
    ];

    protected $table = 'users';

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function hasRole(Role $role)
    {
        return $this->role()->whereIn('name', $role)->count();
    }

    // public function hasPermission(User $user, Permission $permission)
    // {
    //     return $user->role()->whereHas('permissions', function($query) use($permission){
    //         $query->where('slug', $permission->slug);
    //     })->count();
    // }

    // public function grantPermission(Permission $permission)
    // {
    //     $this->role->permissions()->attach($permission);
    // }
    
    // public function revokePermission(Permission $permission)
    // {
    //     // dd($this->role->permissions());
    //     $this->role->permissions()->detach($permission);
    // }

    private function getPermissionIds(Permission ...$permissions){
        return Permission::whereIn('slug', $permissions)->get()->pluck('id')->toArray();

    }
}
