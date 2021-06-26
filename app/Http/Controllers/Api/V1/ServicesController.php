<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Response;
use App\Http\Resources\PlanResource;
use Illuminate\Database\Eloquent\Model;
use App\Http\Repositories\PlanRepository;
use App\Http\Repositories\ServiceRepository;
use App\Http\Requests\PlanRequest;
use App\Http\Requests\ServiceRequest;
use ArrayAccess;

class ServicesController extends AbstractController
{

    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->repository = $serviceRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceRequest $request)
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
    public function update(ServiceRequest $request, $id)
    {
        return parent::updateItem($request->validated(), $id);
    }
}
