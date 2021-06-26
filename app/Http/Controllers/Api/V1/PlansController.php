<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Response;
use App\Http\Resources\PlanResource;
use Illuminate\Database\Eloquent\Model;
use App\Http\Repositories\PlanRepository;
use App\Http\Requests\PlanRequest;
use ArrayAccess;

class PlansController extends AbstractController
{

    
    public function __construct(PlanRepository $planRepository)
    {
        $this->repository = $planRepository;
        // $this->resource = PlanResource::class;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index()
    // {
        // dd(collect(data_get(request()->input(), 'include', [])));

        // return Plan::with(['services', 'subscribers'])->get();
    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PlanRequest $request)
    {
        return parent::createItem($request->validated());
        // return  $this->itemResponse($this->repository->store(), "Data stored successfully", Response::HTTP_CREATED);
        // if($result instanceof Model){
            // return new $this->resource($result);
        // }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
        // return parent::getById($id);
        // return new $this->resource($this->repository->show($id));
        // if($result instanceof ArrayAccess){
        //     return new $this->resource($result);
        // }
        // return $this->respondError($result, Response::HTTP_NOT_FOUND, $id);
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(PlanRequest $request, $id)
    {
        return parent::updateItem($request->validated(), $id);
        // if($result instanceof Model){
        // return new $this->resource($result);
        // }else{
        // return $this->respondError($result, Response::HTTP_NOT_FOUND, $id);
        // }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id)
    // {
        // return parent::deleteItem($id);
            // return $this->respondError($result, Response::HTTP_NOT_FOUND, $id);
    // }
}
