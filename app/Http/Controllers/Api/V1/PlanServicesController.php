<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Plan;
use App\Models\Service;
use Illuminate\Http\Request;
use App\Http\Requests\AddServiceToPlanRequest;
use App\Http\Repositories\PlanServiceRepository;
use App\Http\Controllers\Api\V1\AbstractController;
use Illuminate\Http\Response;

class PlanServicesController extends AbstractController
{
    public function __construct(PlanServiceRepository $planServiceRepository)
    {
        $this->repository = $planServiceRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddServiceToPlanRequest $request, Plan $plan, Service $service)
    {
        $result = $this->repository->addServiceToPlan($request->validated(), $plan, $service);
        return $this->respondSuccess(null, "Service added to plan successfully", Response::HTTP_CREATED);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AddServiceToPlanRequest $request, Plan $plan, Service $service)
    {
        $result = $this->repository->updateServiceOnPlan($request->validated(), $plan, $service);
        return $this->respondSuccess(null, "Service on plan updated successfully", Response::HTTP_OK);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Plan $plan, Service $service)
    {
        $result = $this->repository->removeServiceFromPlan($plan, $service);
        return $this->respondSuccess(null, "Service removed from plan successfully", Response::HTTP_NO_CONTENT);
    }
}
