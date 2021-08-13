<?php

namespace App\Http\Services\LimitCalculators;

use Illuminate\Validation\ValidationException;
use App\Http\Services\LimitCalculators\LimitCalculator;
use Illuminate\Support\Facades\DB;

class AnnualLimitCalculator extends LimitCalculator{
    private  $serviceLimitGroupLimitTotal;

    public function serviceCoverableLimit() : array
    {
        
        $serviceLimit = $this->getPlanServiceLimit();
        $amountCoveredFromLastSubscription = $this->amountCoveredFromLastSubscription();
        $countDownStartedAt = $this->subscriptionStartedDate();
        $serviceLimitGroupId = $this->service->service_limit_group_id;
        $this->serviceLimitGroupLimitTotal = $this->serviceLimitGroupLimitTotal($serviceLimitGroupId);

        // dd($this->subscription->subscriber()->with(['plan.serviceLimitGroups' => function($query) use ($serviceLimitGroupId){
        //     return $query->wherePivot('plan_id', 2)->wherePivot('service_limit_group_id',$serviceLimitGroupId);
        // }])->first()->plan->serviceLimitGroups->first());
        
        // dd($this->service->with('plans.serviceLimitGroups')->get());
        
        if($amountCoveredFromLastSubscription >= $this->serviceLimitGroupLimitTotal){
            $result = 0;
        }else{
            $result = $this->getServiceLimitCoverable($this->serviceLimitGroupLimitTotal, $amountCoveredFromLastSubscription);
        }

        return [
            'service_limit' => $this->serviceLimit,
            'service_limit_group_total' => $this->serviceLimitGroupLimitTotal,
            'service_calculation_type' => 'Annually',
            'insurance_covered_limit' => $result
        ];
    }
    
    
    private function getPlanServiceLimit()
    {
        return $this->serviceLimit = $this->service->with(['plans' => function($query){
            return $query->wherePivot('plan_id', $this->subscription->subscriber->plan_id);
        }])->where('id', $this->service->id)->first()->plans[0]->getOriginal('pivot_limit_total');
    }


    private function getServiceLimitCoverable($serviceLimitGroupLimitTotal, $amountCovered)
    {
        // $this->serviceLimit = $this->service->with(['plans' => function($query){
        //     return $query->wherePivot('plan_id', $this->subscription->subscriber->plan_id);
        // }])->where('id', $this->service->id)->first()->plans[0]->getOriginal('pivot_limit_total');

        if($this->subscription->plan_remaining > 0){
            if($this->serviceLimit && $this->serviceLimit < ($serviceLimitGroupLimitTotal-$amountCovered)){
                return $this->subscription->plan_remaining >= $this->serviceLimit ? $this->serviceLimit : $this->subscription->plan_remaining;
            }else{

                return $this->subscription->plan_remaining >= ($serviceLimitGroupLimitTotal - $amountCovered) ? $serviceLimitGroupLimitTotal - $amountCovered : $this->subscription->plan_remaining;
            }
        }
        return $this->subscription->plan_remaining;
    }

    // public function serviceCoverableLimit() : float
    // {
    //     dd("OK");
    //     if($this->isServiceReceiveable()){
            
    //     }
    //     return 100.0;
    // }

}