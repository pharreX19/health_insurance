<?php

namespace App\Http\Services\LimitCalculators;

use Illuminate\Validation\ValidationException;
use App\Http\Services\LimitCalculators\LimitCalculator;

class PerEventLimitCalculator extends LimitCalculator{

    public function serviceCoverableLimit() : float
    {
        return 1.0;
    //     $serviceLastReceived = $this->serviceRecievedDate();
    //     $countDownStartedAt = $this->serviceLimitGroupStartDate();
    //     if($serviceLastReceived->pivot->activity_at > $countDownStartedAt){
    //         throw ValidationException::withMessages([
    //             "subscription" => "Service is covered once a year"
    //         ]);
    //     }
    //     return true;
    // }

    // public function serviceCoverableLimit() : float
    // {
    //     return 12.0;
    }

}