<?php

namespace App\Http\Services;

use Exception;
use Carbon\Carbon;
use App\Models\Plan;
use App\Models\Subscription;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PlanSubscriptionService{

    private $previousSubscription;
    private $model;

    public function __construct(Subscription $subscription)
    {
        $this->model = $subscription;
    }

    public function subscribe($validatedData, $id = null)
    {
        $subscriberId = $validatedData["subscriber_id"];
        $planId = $validatedData["plan_id"];

        if (
            !$this->subscriptionExists($subscriberId,$planId, $id) && $id === null ||
            ($id && !$this->subscriptionIsActive($subscriberId, $planId, $id))
        ) {
            $planLimitTotal = $this->getPlanLimit($validatedData["plan_id"]);
            DB::beginTransaction();
            try {
                $this->model->create([
                    "subscriber_id" => $subscriberId,
                    "plan_id" =>$planId,
                    "plan_remaining" => $planLimitTotal,
                    "begin_date" => $validatedData["begin_date"] ?? Carbon::now()->toDateString(),
                ]);

                if($this->previousSubscription){
                    $this->markPreviousSubscriptionAsInactive();
                }

                DB::commit();
                return true;
            } catch (Exception $ex) {
                throw $ex;
            }
        }
    }

    
    public function subscriptionExists($subscriberId, $planId = null, $id = null)
    {
        $query =  $this->model->query();
        $query = $query->where('subscriber_id', $subscriberId);
        
        $query->when($id, function($q) use ($planId){
            $q->where("plan_id", $planId);
        });

        $query->when($id, function ($q) use ($id) {
            $q->where("id", $id);
        });

        $result = $query->latest("id")->first();

        if (!$result && $id) {
            throw ValidationException::withMessages([
                "subscription" => "Not subscribed to ".($id ? "this" : "a")." plan"
            ]);
        }
        if($id){
            $this->setPreviousSubscription($result);
        }
        return $result;
    }


    public function validSubscription($subscriberId, $planId=null, $id=null)
    {
        $result = $this->subscriptionExists(...func_get_args());
        if($result->expiry_date >= Carbon::now()->format('Y-m-d')){
            return  $result;
        }
        throw ValidationException::withMessages([
            "subscription" => "Subscription is expired"
        ]);
    }


    private function subscriptionIsActive($subscriberId, $planId, $id=null)
    {
        return $this->subscriptionExists(...func_get_args())->expiry_date >= Carbon::now()->format('Y-m-d');   
    }


    private function setPreviousSubscription($subscription)
    {
        $this->previousSubscription = $subscription;
    }
    

    private function markPreviousSubscriptionAsInactive()
    {
        $this->previousSubscription->is_active = false;
        $this->previousSubscription->save();
    }
    

    private function getPlanLimit($planId)
    {
        return Plan::where('id', $planId)->value("limit_total");
    }

}