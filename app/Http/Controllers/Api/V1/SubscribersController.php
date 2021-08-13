<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Response;
use App\Http\Resources\PlanResource;
use Illuminate\Database\Eloquent\Model;
use App\Http\Repositories\PlanRepository;
use App\Http\Repositories\ServiceLimitGroupRepository;
use App\Http\Repositories\ServiceRepository;
use App\Http\Repositories\ServiceTypeRepository;
use App\Http\Repositories\SubscriberRepository;
use App\Http\Requests\PlanRequest;
use App\Http\Requests\ServiceLimitGroupRequest;
use App\Http\Requests\ServiceRequest;
use App\Http\Requests\ServiceTypeRequest;
use App\Http\Requests\SubscriberRequest;
use App\Models\Plan;
use App\Models\Subscriber;
use ArrayAccess;
use Illuminate\Support\Facades\Request;

class SubscribersController extends AbstractController
{

    public function __construct(SubscriberRepository $subscriberRepository)
    {
        $this->repository = $subscriberRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubscriberRequest $request)
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
    public function update(SubscriberRequest $request, $id)
    {
        return parent::updateItem($request->validated(), $id);
    }

    public function search($identification){
        return $this->respondSuccess(["data" => $this->repository->search($identification)], "Record fetched successfully");
    }

}
