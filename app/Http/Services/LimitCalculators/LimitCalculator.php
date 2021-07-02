<?php

namespace App\Http\Services\LimitCalculators;

use App\Models\Service;
use App\Models\ServiceLimitGroup;
use App\Models\Subscription;

abstract class LimitCalculator{

    protected $service;
    protected $subscription;
    

    public function __construct(Service $service, Subscription $subscription)
    {   
        $this->service = $service;
        $this->subscription = $subscription;

    }

    protected function serviceLimitGroupStartDate(){
        return $this->subscription->begin_date->toDateString();
    }

    protected function serviceRecievedDate(){
        return $this->service->subscribers()->orderBy("id", "desc")->where('subscribers.id', $this->subscription->subscriber_id)->first();
    }

    abstract function isServiceReceiveable() : bool;
}