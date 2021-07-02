<?php

namespace App\Http\Repositories;

use App\Models\Plan;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Repostories\RepositoryInterface;
use App\Models\ServiceLimitGroup;

class ServiceLimitGroupRepository extends BaseRepository
{

    public function __construct()
    {
        $this->model = ServiceLimitGroup::class;
        $this->allowedIncludes = ['services', 'plans'];

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
    // public function store($validatedDate)
    // {
        
    // }

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
    // public function update(Request $request, $id){

    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id){
        // dd($this->model::delete($id));
    // }
}
