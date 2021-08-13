<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Response;
use App\Http\Resources\PlanResource;
use Illuminate\Database\Eloquent\Model;
use App\Http\Repositories\PlanRepository;
use App\Http\Repositories\ServiceLimitGroupRepository;
use App\Http\Repositories\ServiceRepository;
use App\Http\Repositories\ServiceTypeRepository;
use App\Http\Requests\PlanRequest;
use App\Http\Requests\ServiceLimitGroupRequest;
use App\Http\Requests\ServiceRequest;
use App\Http\Requests\ServiceTypeRequest;
use ArrayAccess;

class ServiceTypesController extends AbstractController
{

    public function __construct(ServiceTypeRepository $serviceTypeRepository)
    {
        $this->repository = $serviceTypeRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceTypeRequest $request)
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
    public function update(ServiceTypeRequest $request, $id)
    {
        return parent::updateItem($request->validated(), $id);
    }
}
