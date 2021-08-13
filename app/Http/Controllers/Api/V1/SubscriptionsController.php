<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Plan;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Repositories\SubscriptionRepository;
use App\Http\Controllers\Api\V1\AbstractController;
use App\Http\Requests\SubscriptionRequest;

class SubscriptionsController extends AbstractController
{
    public function __construct(SubscriptionRepository $subscriptionRepository)
    {
        $this->repository = $subscriptionRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SubscriptionRequest $request)
    {
        $result = $this->repository->store($request->validated());
        if(!$result){
            return $this->respondError("Already subscribed to a plan", Response::HTTP_CONFLICT);
        } 
        return $this->respondSuccess(null, "Successfully subscribed to the new plan", Response::HTTP_CREATED);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SubscriptionRequest $request, $id)
    {
        $result = $this->repository->update($request->validated(), $id);
        if(!$result){
            return $this->respondError("Subscription is not expired", Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        return $this->respondSuccess(['data' => $result], "Successfully renewed the subscription", Response::HTTP_CREATED);
    }

    

    public function subscribe(Subscriber $subscriber, Plan $plan)
    {
        $result = $this->repository->subscribe($subscriber, $plan);
        if(!$result){
            return $this->respondError("Already subscribed to a plan", Response::HTTP_CONFLICT);
        }
        return $this->respondSuccess(null, "Successfully subscribed to the new plan", Response::HTTP_CREATED);
    }


    public function destroy($id)
    {
        $result = $this->repository->destroy($id);
        if(!$result){
            return $this->respondError("No active subscription found for the selected plan", Response::HTTP_NOT_FOUND);
        }
        return $this->respondSuccess(null, "Successfully unsubscribed the selected plan", Response::HTTP_CREATED);
    }


    // public function renewSubscription(Subscriber $subscriber, Plan $plan)
    // {
        
    // }
    
}
