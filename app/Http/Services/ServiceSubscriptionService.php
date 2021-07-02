<?php

namespace App\Http\Services;

use Illuminate\Validation\ValidationException;

class ServiceSubscriptionService{

    public function getPlanServiceLimit($plan, $service, $subscription)
    {
        $planRemaining = $this->getPlanRemaining($subscription);

        if($this->isServiceCoverable($service, $subscription)){
            $serviceLimitTotal = $plan->services()->wherePivot('plan_id', $plan->id)->wherePivot('service_id', $service->id)->value("limit_total");
            if($serviceLimitTotal > $planRemaining){
                $serviceLimitTotal = $planRemaining;
            }
            return $serviceLimitTotal;
        }
    }

    private function getPlanRemaining($subscription){
        $planRemaining =  $subscription->plan_remaining;
        if($planRemaining <= 0){
            throw ValidationException::withMessages([
                "subscription" => "Subscription has zero balance"
            ]);
        }
        return $planRemaining;
    }


    private function isServiceCoverable($service, $subscription){
        $limitGroupSlug = $service->limitGroup()->value("slug");
        return $service->limitGroup()->getRelated()->limitCalculator($limitGroupSlug, $service, $subscription);
    }
    
    private function checkIfServiceIsOnPlan($plan, $service){
        return in_array($service->toArray(), $plan->services->makeHidden('pivot')->toArray());
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