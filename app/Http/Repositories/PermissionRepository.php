<?php

namespace App\Http\Repositories;

use App\Models\Plan;
use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Repostories\RepositoryInterface;

class PermissionRepository extends BaseRepository
{

    public function __construct()
    {
        $this->model = Permission::class;
    }
}
