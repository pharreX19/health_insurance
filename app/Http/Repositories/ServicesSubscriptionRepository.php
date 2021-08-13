<?php

namespace App\Http\Repositories;

use App\Http\Services\PlanSubscriptionService;
use Exception;
use Carbon\Carbon;
use App\Models\Plan;
use App\Models\Service;
use App\Models\Subscriber;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Services\SubscriptionService;
use App\Http\Services\ServiceSubscriptionService;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;

class ServicesSubscriptionRepository extends BaseRepository
{
    protected $service;

    public function __construct(ServiceSubscriptionService $subscriptionService)
    {
        $this->service = $subscriptionService;

    }

    public function post(Subscriber $subscriber, Service $service)
    {
        $currentSubscription = (new PlanSubscriptionService($subscriber->subscriptions()->getRelated()))->validSubscription($subscriber->id,1);

        if ($currentSubscription && $this->service->serviceExistsOnPlan($currentSubscription->plan, $service)) {

            $planServiceLimit = $this->service->getPlanServiceLimit($currentSubscription->plan, $service, $currentSubscription);
            DB::beginTransaction();
            try {
                $subscriber->services()->attach($service->id, [
                    "covered_limit" => $planServiceLimit,
                ]);

                $currentSubscription->plan_remaining -= $planServiceLimit;
                $currentSubscription->save();

                DB::commit();
                return true;
            } catch (Exception $ex) {
                DB::rollBack();
                throw $ex;
            }
        }
        return false;
    }



    // DB::beginTransaction();

    // $result = $this->service->getServiceLimitAndSubscriptionRemaining($request, $service, $subscriber);

    // $serviceCoverageLimit= $result->plans->first()->pivot->limit_total;
    // $subscriberPlan = $result->plans->first()->subscribers->first()->pivot;


    // if($serviceCoverageLimit > $subscriberPlan->plan_remaining){
    //     $serviceCoverageLimit = $subscriberPlan->plan_remaining;
    // }

    // if($subscriberPlan->plan_remaining == 0){
    //     throw(new UnprocessableEntityHttpException("Cannot be processed"));
    // }

    // try{        
    //     $subscriber->services()->attach($service->id, [
    //         'covered_limit' => $serviceCoverageLimit,
    //         'created_at' => Carbon::now()
    //     ]);

    //     $subscriberPlan->plan_remaining -= $serviceCoverageLimit;
    //     $subscriberPlan->save();

    //     DB::commit();
    //     return true;
    // }
    // catch(Exception $ex){
    //     DB::rollBack();
    //     throw($ex);
    // }      


    // public function unsubscribe(Subscriber $subscriber, Plan $plan)
    // {
    //     DB::beginTransaction();
    //     $subscription = $this->subscriptionExists($subscriber, $plan);

    //     if($subscription && $this->SubscriptionIsValid($subscription)){
    //         try{        
    //             $subscriber->plans()->attach($plan->id, [
    //                 "expiry_date" => Carbon::now(),
    //                 "plan_remaining" => $subscription->pivot->plan_remaining
    //             ]);
    //             DB::commit();
    //             return true;
    //         }
    //         catch(Exception $ex){
    //             DB::rollBack();
    //             throw($ex);
    //         }
    //     }
    //     return false;        
    // }


    // public function renewSubscription(Subscriber $subscriber, Plan $plan)
    // {
    //     DB::beginTransaction();
    //     $subscription = $this->subscriptionExists($subscriber, $plan);

    //     if($subscription && !$this->SubscriptionIsValid($subscription)){
    //         return $this->makeSubscription($subscriber, $plan);
    //     }
    //     return false;        
    // }

    // private function makeSubscription($subscriber, $plan){
    //     try{        
    //         $subscriber->plans()->attach($plan->id, [
    //             'plan_remaining' => $plan->limit_total,
    //             'created_at' => Carbon::now()
    //         ]);
    //         DB::commit();
    //         return true;
    //     }
    //     catch(Exception $ex){
    //         DB::rollBack();
    //         throw($ex);
    //     }
    // }





}
