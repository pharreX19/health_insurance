<?php

namespace App\Http\Repositories;

use App\Models\Plan;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Repostories\RepositoryInterface;
use App\Models\Permission;

class UserRepository extends BaseRepository
{

    public function __construct()
    {
        $this->model = User::class;
        $this->allowedIncludes = ['role', 'role.permissions', 'serviceProviders'];
        $this->allowedFilters = ['role_id'];

    }

    public function assignRole(User $user, Role $role)
    {
        if(!$user->hasRole($role)){
            $user->update([
                'role_id' => $role->id
            ]);
            // dd($user);
            // $role->save();
        }
        return true;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index(){

    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($validatedData)
    {
        $result = parent::store($validatedData);
        // dd($result->toArray());
        // dd($validatedData['service_provider_id']);
        $this->attachServiceProviders($result, $validatedData);    
        return $result;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
        // dd(QueryBuilder::for($this->model)->allowedIncludes($this->allowedIncludes)->get());

        // return QueryBuilder::for($this->model::where('id', $id))->allowedIncludes($this->allowedIncludes)->first();

        // return $this->model::find($id);
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($validatedData, $id){
        $result = parent::update($validatedData, $id);
        $this->attachServiceProviders($result, $validatedData);
        return $result;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id){
        // dd($this->model::delete($id));
    // }

    public function attachServiceProviders($model, $validatedData)
    {
        if($validatedData['service_provider_id']){
            $model->serviceProviders()->sync($validatedData['service_provider_id']);
        }
    }
}
