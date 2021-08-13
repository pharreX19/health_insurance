<?php

namespace App\Http\Repositories;

use App\Models\Plan;
use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Repostories\RepositoryInterface;

class RoleRepository extends BaseRepository
{

    public function __construct()
    {
        $this->model = Role::class;
        $this->allowedIncludes = ['users', 'permissions'];
    }

    public function grantOrRevokePermission(Role $role, Permission $permission)
    {
        if(!$role->hasPermission($role, $permission)){
            // dd('YAY');
            return $role->grantPermission($permission);
        }
        // dd('NOT FOUND');
        return $role->revokePermission($permission);
    }

    
}
