<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Repositories\PermissionRepository;
use App\Http\Controllers\Api\V1\AbstractController;

class PermissionController extends AbstractController
{
    public function __construct(PermissionRepository $permissionRepository)
    {
        $this->repository = $permissionRepository;
    }
}
