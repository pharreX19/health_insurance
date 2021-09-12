<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Plan;
use Illuminate\Http\Response;
use App\Models\ServiceLimitGroup;
use App\Http\Controllers\Api\V1\AbstractController;
use App\Http\Repositories\PlanServiceLimitGroupRepository;
use App\Http\Repositories\ServiceLimitGroupRepository;
use App\Http\Requests\PlanServiceLimitGroupRequest;

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
    public function store(Plan $plan, PlanServiceLimitGroupRequest $request)
    {
        $result = $this->repository->addServiceLimitGroupToPlan($plan, $request->validated());
        return $this->respondSuccess(null, "Service limit group added to plan successfully", Response::HTTP_CREATED);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Plan $plan, PlanServiceLimitGroupRequest $request)
    {
        $result = $this->repository->updateServiceLimitGroupOnPlan($plan, $request->validated(),);
        return $this->respondSuccess(null, "Service limit group on plan updated successfully", Response::HTTP_OK);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function delete(Plan $plan, ServiceLimitGroup $service)
    // {
    //     $result = $this->repository->removeServiceFromPlan($plan, $service);
    //     return $this->respondSuccess(null, "Service limit group removed from plan successfully", Response::HTTP_NO_CONTENT);
    // }
}
