<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Repositories\UserRepository;
use App\Http\Controllers\Api\V1\AbstractController;
use App\Http\Requests\UserUpdateRequest;

class UsersController extends AbstractController
{

    public function __construct(UserRepository $userRepository)
    {
        $this->repository = $userRepository;
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        return parent::createItem($request->validated());
    //     $this->attachServiceProviders($result['data'], $request->validated());
        // if($request->validated()['service_provider_id']){
        //     $result['data']->serviceProviders()->attach($request->validated()['service_provider_id']);
        // }
        // return $result;
        // $result->serviceProvider()->attach($request->validated()['service_provider_id']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, $id)
    {
        return parent::updateItem($request->validated(), $id);
    //     $this->attachServiceProviders($result['data'], $request->validated());
        // return $result;
    }
    

    public function assignRole(User $user, Role $role)
    {
        return $this->repository->assignRole(...func_get_args());
    }

    


    
}
