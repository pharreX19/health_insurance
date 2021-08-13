<?php

namespace App\Http\Services;

use App\Models\Service;
use App\Models\Subscriber;
use Illuminate\Validation\ValidationException;

class ServiceSubscriptionService{

    public function getPlanServiceLimit($serviceId, $subscriberId)//$plan, $service, $subscription, $subscriberId)
    {
        ///////////
        $subscriber = $this->getSubscriber($subscriberId);
        $service = $this->getService($serviceId);
        $currentSubscription = (new PlanSubscriptionService($subscriber->subscriptions()->getRelated()))->validSubscription($subscriber->id, $subscriber->plan_id);  
        // dd($subscriber->plan);
        // dd($subscriber,$service);
        // dd($this->checkIfServiceIsOnPlan($subscriber->plan, $service));
        if ($currentSubscription && $this->checkIfServiceIsOnPlan($subscriber->plan, $service)) {
            $result =  $this->getServiceCoverableLimit($subscriber->plan, $service, $currentSubscription);
            return array_merge($result, ['current_subscription' => $currentSubscription]);
        }else{
            return [
                'insurance_covered_limit' => 0,
                'service_limit' => null
            ];
        }
        ////////
        // $planRemaining = $this->getPlanRemaining($subscription);
        // return $this->getServiceCoverableLimit($currentSubscription->plan, $service, $currentSubscription);
        // if($this->isServiceCoverable($plan, $service, $subscription)){
        //     $serviceLimitTotal = $this->getPlanService($plan, $service)->value("limit_total");
        //     if($serviceLimitTotal > $planRemaining){
        //         $serviceLimitTotal = $planRemaining;
        //     }
        //     return $serviceLimitTotal;
        // }
    }

    // private function getPlanRemaining($subscription){
    //     $planRemaining =  $subscription->plan_remaining;
    //     if($planRemaining <= 0){
    //         throw ValidationException::withMessages([
    //             "subscription" => "Subscription has zero balance"
    //         ]);
    //     }
    //     return $planRemaining;
    // }
    //////////////
    private function getSubscriber($subscriberId)
    {
        return Subscriber::findOrFail($subscriberId);
    }

    private function getService($serviceId)
    {
        return Service::findOrFail($serviceId);
    }



    //////////////

    private function getPlanService($plan, $service){
        return $plan->services()->wherePivot('plan_id', $plan->id)->wherePivot('service_id', $service->id)->first();
    }


    private function getServiceCoverableLimit($plan, $service, $subscription){
        $planService = $this->getPlanService($plan, $service);

        // $limitGroupSlug = $service->serviceLimitGroup()->value("slug");
        // dd($subscription);
        return $service->serviceLimitGroup()->getRelated()->limitCalculator($planService->getOriginal('pivot_limit_calculator'), $service, $subscription);//->subscriptions()->latest()->first());
    }
    
    private function checkIfServiceIsOnPlan($plan, $service){
        // dd($plan->services);
        return in_array($service->toArray(), $plan->services->makeHidden('pivot')->toArray());//->makeHidden('pivot')->toArray());
    }


    public function serviceExistsOnPlan($plan, $service)
    {
        $result =  $this->checkIfServiceIsOnPlan(...func_get_args());
        //in_array($service->toArray(), $plan->services->makeHidden('pivot')->toArray());
        if(!$result){
            throw ValidationException::withMessages([
                "subscription" => "Service not found on this plan"
            ]);
        }
        return $result;
    }

    public function serviceDoesNotExistOnPlan($plan, $service)
    {
        $result =  $this->checkIfServiceIsOnPlan(...func_get_args());
        //in_array($service->toArray(), $plan->services->makeHidden('pivot')->toArray());
        if($result){
            throw ValidationException::withMessages([
                "subscription" => "Service already registered on this plan"
            ]);
        }
        return $result;
    }
}