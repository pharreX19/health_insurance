<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Plan;
use App\Models\Service;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Repositories\SubscriptionRepository;
use App\Http\Controllers\Api\V1\AbstractController;
use App\Http\Repositories\ServicesSubscriptionRepository;

class ServicesSubscriptionController extends AbstractController
{

    public function __construct(ServicesSubscriptionRepository $servicesSubscriptionRepository)
    {
        $this->repository = $servicesSubscriptionRepository;
    }

    public function post(Request $request, Subscriber $subscriber, Service $service)
    {
        $result = $this->repository->post($subscriber, $service);
        
        if(!$result){
            return $this->respondError("No active subscription found for this plan", Response::HTTP_CONFLICT);
        }
        return $this->respondSuccess(null, "Service recieved successfully", Response::HTTP_CREATED);
    }


    public function destroy($id){
        dd("Delete");
    }
    


    // public function unsubscribe(Request $request, Subscriber $subscriber, Plan $plan)
    // {
    //     $result = $this->repository->unsubscribe($subscriber, $plan);
    //     if(!$result){
    //         return $this->respondError("No active subscription found for the selected plan", Response::HTTP_NOT_FOUND);
    //     }
    //     return $this->respondSuccess(null, "Successfully unsubscribed the selected plan", Response::HTTP_CREATED);
    // }


    // public function renewSubscription(Request $request, Subscriber $subscriber, Plan $plan)
    // {
    //     $result = $this->repository->renewSubscription($subscriber, $plan);
    //     if(!$result){
    //         return $this->respondError("Subscription is not expired", Response::HTTP_UNPROCESSABLE_ENTITY);
    //     }
    //     return $this->respondSuccess(null, "Successfully renewed the subscription", Response::HTTP_CREATED);
    // }
    
}
