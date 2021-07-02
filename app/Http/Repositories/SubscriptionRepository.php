<?php

namespace App\Http\Repositories;

use Exception;
use Carbon\Carbon;
use App\Models\Plan;
use App\Models\Subscriber;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Services\SubscriptionService;
use App\Http\Services\PlanSubscriptionService;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class SubscriptionRepository extends BaseRepository
{

    protected $service; 

    public function __construct()
    {
        $this->model = Subscription::class;
        $this->allowedIncludes = ['plan', 'subscriber'];
        $this->service = new PlanSubscriptionService(new Subscription());
    }

    public function store($validatedData)
    {
        return $this->service->subscribe($validatedData);
    }


    public function update($validatedData, $id)
    {
        return $this->service->subscribe($validatedData, $id);
    }

    public function destroy($id)
    {
        return parent::update(new Request(["is_active" => false]), $id);
    }


    
    // public function unsubscribe(Subscriber $subscriber, Plan $plan)
    // {
    //     DB::beginTransaction();
    //     $subscription = $this->subscriptionExists($subscriber, $plan);

    //     if ($subscription && $this->SubscriptionIsValid($subscription, 1)) {
    //         try {
    //             $subscriber->plans()->attach($plan->id, [
    //                 "expiry_date" => Carbon::now(),
    //                 // "plan_remaining" => $subscription->pivot->plan_remaining
    //             ]);
    //             DB::commit();
    //             return true;
    //         } catch (Exception $ex) {
    //             DB::rollBack();
    //             throw ($ex);
    //         }
    //     }
    //     return false;
    // }

    

    


    
}
