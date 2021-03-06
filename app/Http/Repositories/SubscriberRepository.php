<?php

namespace App\Http\Repositories;

use Exception;
use Carbon\Carbon;
use App\Models\Plan;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use App\Http\Traits\PolicyNumber;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Repostories\RepositoryInterface;
use Illuminate\Validation\ValidationException;

class SubscriberRepository extends BaseRepository
{
    use PolicyNumber;

    public function __construct()
    {
        $this->model = Subscriber::class;
        $this->allowedIncludes = ['plan', 'subscriptions', 'company', 'episodes.services', 'episodes.serviceProvider', 'plan.services'];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    // public function index(){

    // }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($validatedData)
    {
        // $plan_id = $validatedData['plan_id'];
        $results = [];
        $policy_number = $this->generatePolicyNumber($validatedData[0]['plan_id']);
        
        foreach ($validatedData as $data) {
            if (isset($data['plan_id']) && $this->userHasBalance($data)) {
                $result = parent::store($data);
                array_push($results, $result);
                if ($result && isset($data['plan_id'])) {
                    $data['policy_number'] = $policy_number;
                    $data['subscriber_id'] = $result['id'];
                    (new SubscriptionRepository)->store($data);
                }
            }
        }
        return $results;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function show($id)
    // {
    // dd(QueryBuilder::for($this->model)->allowedIncludes($this->allowedIncludes)->get());

    // return QueryBuilder::for($this->model::where('id', $id))->allowedIncludes($this->allowedIncludes)->first();

    // return $this->model::find($id);
    // }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, $id){

    // }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    // public function destroy($id){
    // dd($this->model::delete($id));
    // }

    public function search($identification)
    {
        return $this->model::join('subscriptions', 'subscribers.id', '=', 'subscriptions.subscriber_id')->where('national_id', 'LIKE', $identification . "%")->orWhere('work_permit', 'LIKE',  $identification . "%")->orWhere('passport', 'LIKE', $identification . "%")->orWhere('policy_number', 'LIKE', $identification . "%")->get();
    }

    private function userHasBalance($validatedData)
    {
        $planPremium = Plan::where('id', $validatedData["plan_id"])->value('premium');

        if (Auth::user()->role_id != 1 && Auth::user()->amount < $planPremium) {
            throw ValidationException::withMessages([
                'message' => 'Please recharge your account'
            ]);
        }
        return true;
    }
}
