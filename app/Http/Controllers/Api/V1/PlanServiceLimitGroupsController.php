<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Plan;
use Illuminate\Http\Response;
use App\Models\ServiceLimitGroup;
use App\Http\Controllers\Api\V1\AbstractController;
use App\Http\Repositories\PlanServiceLimitGroupRepository;

class PlanServiceLimitGroupsController extends AbstractController
{
    public function __construct(PlanServiceLimitGroupRepository $planServiceLimitGroupRepository)
    {
        $this->repository = $planServiceLimitGroupRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Plan $plan, ServiceLimitGroup $serviceLimitGroup)
    {
        $result = $this->repository->addServiceLimitGroupToPlan($plan, $serviceLimitGroup);
        return $this->respondSuccess(null, "Service added to plan successfully", Response::HTTP_CREATED);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Plan $plan, ServiceLimitGroup $serviceLimitGroup)
    {
        // $result = $this->repository->updateServiceOnPlan($request->validated(), $plan, $service);
        return $this->respondSuccess(null, "Service on plan updated successfully", Response::HTTP_OK);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete(Plan $plan, ServiceLimitGroup $service)
    {
        $result = $this->repository->removeServiceFromPlan($plan, $service);
        return $this->respondSuccess(null, "Service removed from plan successfully", Response::HTTP_NO_CONTENT);
    }
}
