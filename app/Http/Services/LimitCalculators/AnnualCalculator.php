<?php

namespace App\Http\Services\LimitCalculators;

use Illuminate\Validation\ValidationException;
use App\Http\Services\LimitCalculators\LimitCalculator;

class AnnualCalculator extends LimitCalculator{

    public function isServiceReceiveable() : bool
    {
        $serviceLastReceived = $this->serviceRecievedDate();
        $countDownStartedAt = $this->serviceLimitGroupStartDate();
        if($serviceLastReceived->pivot->activity_at > $countDownStartedAt){
            throw ValidationException::withMessages([
                "subscription" => "Service is covered once a year"
            ]);
        }
        return true;
    }

}