<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Repositories\RoleRepository;
use App\Http\Controllers\Api\V1\AbstractController;
use App\Http\Requests\RoleRequest;

class RoleController extends AbstractController
{
    public function __construct(RoleRepository $roleRepository)
    {
        $this->repository = $roleRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        return parent::createItem($request->validated());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request, $id)
    {
        return parent::updateItem($request->validated(), $id);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        return parent::destroy($id);
    }


    public function grantOrRevokePermission(Role $role, Permission $permission)
    {
        return $this->repository->grantOrRevokePermission(...func_get_args());
    }

}
