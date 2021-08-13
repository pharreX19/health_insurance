<?php

namespace App\Http\Services\LimitCalculators;

use App\Models\Service;
use App\Models\Subscription;
use App\Models\ServiceLimitGroup;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

abstract class LimitCalculator{

    protected $service;
    protected $subscription;
    

    public function __construct(Service $service, Subscription $subscription)
    {   
        $this->service = $service;
        $this->subscription = $subscription;

    }

    protected function subscriptionStartedDate(){
        return $this->subscription->begin_date->toDateString();
    }

    protected function serviceLimitGroupLimitTotal($serviceLimitGroupId){
        $query = $this->subscription->subscriber->plan->with(['serviceLimitGroups' => function($query) use($serviceLimitGroupId){
            return $query->where('service_limit_group_id', $serviceLimitGroupId);
        }])->where('id', $this->subscription->subscriber->plan_id)->first();

        if(count($query->serviceLimitGroups) > 0){
            return $query->serviceLimitGroups[0]->getOriginal('pivot_limit_total');
        }
        else{
            return $this->subscription->plan_remaining;
            // throw ValidationException::withMessages([
            //     'message' => 'No Service limit group found for this service on this plan'
            // ]);
        }
    }

    protected function amountCoveredFromLastSubscription(){
        // dd($this->subscription->subscriber->where('id', $this->subscription->subscriber->id)->with(['episodes.services' => function($query){
        //     $query->where('service_limit_group_id', 1);
        // }])->get());
    

        return DB::table('episodes')->select('episodes.*', 'episode_service.insurance_covered_limit', 'services.service_limit_group_id')->join('episode_service', 'episodes.id', 'episode_service.episode_id')->join('services', 'episode_service.service_id', 'services.id')->where('episodes.subscriber_id', $this->subscription->subscriber->id)->where('service_limit_group_id', $this->service->service_limit_group_id)->whereDate('episodes.activity_at','>=', date($this->subscriptionStartedDate()))->sum('episode_service.insurance_covered_limit');

        // return DB::table('episodes')->select('episode_service.insurance_covered_limit','episode_service.created_at as activity_at')->join('episode_service', function($join){
        //     $join->on('episodes.id', '=', 'episode_service.episode_id')->where('episode_service.service_id', $this->service->id)->where('episodes.subscriber_id', $this->subscription->subscriber->id)->where('episode_service.created_at', '>=', $this->subscriptionStartedDate());
        // })->sum('episode_service.insurance_covered_limit');
       
        // dd($this->subscription->subscriber->episodes()->get());
        // return $this->service->subscribers()->orderBy("id", "desc")->where('subscribers.id', $this->subscription->subscriber_id)->first();
    }

    // abstract function isServiceReceiveable() : bool;
    abstract function serviceCoverableLimit() : array
    ;
}