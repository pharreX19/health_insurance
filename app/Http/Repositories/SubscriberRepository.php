<?php

namespace App\Http\Repositories;

use App\Models\Plan;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Repostories\RepositoryInterface;
use App\Http\Traits\PolicyNumber;
use App\Models\Subscriber;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

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
        foreach($validatedData as $data){
            if(isset($data['plan_id'])){
                $policy_number = $this->generatePolicyNumber($data['plan_id']);
                // dd($policy_number);
                $data['policy_number'] = $policy_number;
            }
            $result = parent::store($data);
            // dd($result);
            if($result && isset($data['plan_id'])){
                // $this->updatePolicyNumber($data['plan_id']);
                $data['subscriber_id'] = $result['id'];
                (new SubscriptionRepository)->store($data);
            }
        }
        return $result;
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

        public function search($identification){
            return $this->model::where('national_id', 'LIKE', $identification."%")->orWhere('work_permit', $identification."%")->orWhere('passport', $identification."%")->firstOrFail();
        }
}
