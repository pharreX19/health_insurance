<?php

namespace App\Http\Services;

use Exception;
use Carbon\Carbon;
use App\Models\Plan;
use App\Models\Subscriber;
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
            !$this->subscriptionExists($subscriberId, $planId, $id) && $id === null ||
            ($id && !$this->subscriptionIsValid($subscriberId, $planId, $id))
        ) {
            $planLimitTotal = $this->getPlanLimit($validatedData["plan_id"]);
            DB::beginTransaction();
            try {
                $subscriber = ($this->model->subscriber()->getRelated()->where('subscribers.id', $subscriberId)->first());
                $subscriber->plan_id = $planId;
                $subscriber->save();

                $result = $this->model->create([
                    "subscriber_id" => $subscriberId,
                    // "plan_id" =>$planId,
                    "plan_remaining" => $planLimitTotal,
                    "begin_date" => $validatedData["begin_date"] ?? Carbon::now()->toDateString(),
                ]);
                

                if($this->previousSubscription){
                    $this->markPreviousSubscriptionAsInactive();
                }

                DB::commit();
                return $result;
            } catch (Exception $ex) {
                throw $ex;
            }
        }
    }

    public function unsubscribe($subscriptionId){
        // dd($this->model->select('subscriber_id')->where('id', $subscriptionId)->first());
        $subscriberId = $this->model->where('id', $subscriptionId)->value('subscriber_id');
        // dd($subscriberId);
        $subscriber = $this->model->subscriber()->getRelated()->where('id', $subscriberId)->first();
        // dd($subscriber);
        $subscriber->plan_id = null;
        return $subscriber->save();
    }

    
    public function subscriptionExists($subscriberId, $planId = null, $id = null)
    {   
        
        // $query =  $this->model->query();
        
        // dd($query);
        //$query->where('subscriber_id', $subscriberId);
        //
        // $query->when($id, function($q) use ($planId){
            // $q->where("plan_id", $planId);
            // }); 
            // $query->when($id, function ($q) use ($id) {
                //     dd($q->where("id", $id)->first());
                //     $q->where("id", $id);
                // });
                // $result = $query->latest("id")->first();          
        $query = $this->model->subscriber()->getRelated()->with(['subscriptions', 'plan'])->where('subscribers.id', $subscriberId)->whereNotNull('plan_id')->first()->subscriptions()->latest()->first();

        if (!$query && $id) {
            throw ValidationException::withMessages([
                "subscription" => "Not subscribed to ".($id ? "this" : "a")." plan"
            ]);
        }
        if($id){
            // $query = $query->subscriptions()->latest()->first();
            $this->setPreviousSubscription($query);
        }
       
        return $query;
    }


    public function validSubscription($subscriberId, $planId, $id=null) //planID was null
    {
        $result = $this->subscriptionExists(...func_get_args());

        if(!$result){
            throw ValidationException::withMessages([
                'message' => 'No subscription found for this user'
            ]);
        }
        // if($result->subscriptions()->latest()->first()->expiry_date >= Carbon::now()->format('Y-m-d')){
            if($result->expiry_date >= Carbon::now()->format('Y-m-d')){
            return  $result;
        }
        throw ValidationException::withMessages([
            "subscription" => "Subscription is expired"
        ]);
    }


    private function subscriptionIsValid($subscriberId, $planId, $id=null) : bool
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