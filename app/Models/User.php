<?php

namespace App\Models;

use App\Models\Role;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use phpDocumentor\Reflection\Types\Boolean;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable, SoftDeletes;

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
        'active',    // 'service_provider_id',
        'role_id',
        'amount'
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

    public static function boot(){
        parent::boot();
        static::creating(function($model){
            $model->active = 1;
            $model->password = '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi';
        });

        static::addGlobalScope('active-user', function($query){
            return $query->where('active', true);
        });
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [
            'service_provider' => $this->serviceProviders()
        ];
    }

    public function serviceProviders()
    {
        return $this->belongsToMany(ServiceProvider::class, 'service_provider_user');
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
