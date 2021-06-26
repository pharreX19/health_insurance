<?php

namespace App\Http\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Model;
use App\Http\Repositories\RepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use PhpParser\Builder\Property;

class BaseRepository implements RepositoryInterface
{
    protected $model;
    protected $allowedSorts = ['created_at', 'updated_at'];
    protected $allowedIncludes = [];
    protected $allowedFilters = [];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return QueryBuilder::for($this->model)->allowedSorts($this->allowedSorts)->allowedFilters($this->allowedFilters)->allowedIncludes($this->allowedIncludes)->paginate(2);
 
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($validatedData){
        try{
            DB::beginTransaction();
            $result =  $this->model::create($validatedData);
            DB::commit();
            return $result;
        }
        catch(Exception $ex){
            throw $ex;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $result =  QueryBuilder::for($this->model::where('id', $id))->allowedIncludes($this->allowedIncludes)->first();
            if(!$result){
                throw new ModelNotFoundException();
            }
            return $result;

        }catch(Exception $ex){
            throw $ex;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($validatedData, $id){
        DB::beginTransaction();

        try{
            $result = $this->find($id);
            $updatedResult = tap($result)->update($validatedData);
            DB::commit();
            return $updatedResult;
        }
        catch(Exception $ex){
            DB::rollBack();
            throw $ex;
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        
        try{
            DB::beginTransaction();
            $this->find($id)->destroy($id);
            DB::commit();
            return true;
            
        }catch(Exception $ex){
            DB::rollBack();
            throw $ex;
        }

    }

    private function find($id){
        return $this->model::findOrFail($id);        
    }

    public function __get($property)
    {
        if(property_exists($this, $property)){
            return $this->$property;
        }
    }
}
