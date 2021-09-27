<?php
namespace App\Http\Traits;

use App\Models\Plan;
use App\Models\Policy;
use Carbon\Carbon;
use Exception;

trait PolicyNumber{
    
    public function generatePolicyNumber(int $planId)
    {
        return $this->makeNumber($planId);
    }

    private function getLatestNumber(Plan $plan): ?array
    {
        $result =  $plan->subscribers()->latest()->first();
        $policy_number = ($result->subscriptions()->value('policy_number'));
        if($policy_number){
            return explode('_', $policy_number);
            // return $result->policy_number;//last(explode("_", $result->policy_number));
        }
        return null;
    }

    private function numberFormatBreakDown(string $format) : array
    {
        return explode("_", $format);
    }

    private function getNumberFormat(Plan $plan) : array
    {
        return explode("_", $plan->policy->number_format);
    }

    private function getYear(): int
    {
        return Carbon::now()->year;
    }

    private function getMonth(): string
    {
        return Carbon::now()->month < 10 ? '0'.Carbon::now()->month : Carbon::now()->month;
    }

    private function getPolicy($planId){
        return Plan::with('policy')->where('plans.id', $planId)->first();
    }

    public function makeNumber(int $planId)
    {
        $plan = $this->getPolicy($planId);
        $numberFormatInArray = $this->getNumberFormat($plan);
        $lastNumberSeq = $this->getLatestNumber($plan) ?? 0;
        try{
            $combinedArray = (array_combine($numberFormatInArray, $lastNumberSeq));
        }catch(Exception $ex){
            $combinedArray = ['SEQ' => 0];
        }

        foreach($numberFormatInArray as &$key){
            switch(strtolower($key)){
                case 'year':
                    $key = $this->getYear();
                    break;
                
                case 'month': 
                    $key = $this->getMonth();
                    break;

                case 'seq': 
                    $key = (int)$combinedArray[$key] + 1;
                    break;
                default: 
                    $key = $key;
                    break;
            }
        }
    
        return implode("_", $numberFormatInArray);
    }




}