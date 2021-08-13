<?php

namespace App\Http\Repositories;

use Exception;
use Carbon\Carbon;
use App\Models\Plan;
use App\Models\PlanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PlanServiceLimitGroup;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Repositories\BaseRepository;
use App\Http\Repostories\RepositoryInterface;
use App\Http\Services\ServiceSubscriptionService;

class PlanServiceLimitGroupRepository extends BaseRepository
{

    public function __construct()
    {
        $this->model = PlanServiceLimitGroup::class;
    }


    public function addServiceLimitGroupToPlan($plan, $serviceLimitGroup, $validatedData)
    {
        $result = $this->serviceLimitGroupDoesNotExistOnPlan($plan, $serviceLimitGroup);
        return $this->serviceToPlan(...func_get_args());
    }


    public function updateServiceLimitGroupOnPlan($plan, $serviceLimitGroup, $validatedData){
        $result = $this->serviceLimitGroupExistsOnPlan($plan, $serviceLimitGroup);
        $this->detachService($plan, $serviceLimitGroup);
        return $this->serviceToPlan(...func_get_args());
    }


    public function removeServiceLimitGroupFromPlan($plan, $serviceLimitGroup)
    {
        $result = $this->serviceLimitGroupExistsOnPlan($plan, $serviceLimitGroup);
        return DB::transaction(function () use ($serviceLimitGroup, $plan){
            $plan->services()->updateExistingPivot($serviceLimitGroup->id, [
                "deleted_at" => Carbon::now()
            ]);
        });
    }


    private function serviceLimitGroupDoesNotExistOnPlan($plan, $serviceLimitGroup){
        $result = $plan->serviceLimitGroups()->wherePivot('service_limit_group_id', $serviceLimitGroup->id)->first();
        
    }

    public function serviceLimitGroupExistsOnPlan()
    {
        
    }


    private function detachService($plan, $serviceLimitGroup){
        return DB::transaction(function () use ($serviceLimitGroup, $plan){
            $plan->services()->detach($serviceLimitGroup->id);
        });
    }


    private function serviceToPlan($plan, $serviceLimitGroup, $validatedData)
    {
       try{
        DB::beginTransaction();
        $plan->serviceLimitGroups()->attach($serviceLimitGroup->id, [
            "limit_total" => $validatedData["limit_total"],
            // "limit_group_calculation_type_id" => $validatedData["limit_group_calculation_type_id"] ?? null,
            "created_at" => Carbon::now(),
            "updated_at" => Carbon::now(),
        ]);
        DB::commit();
        return true;
       }catch(Exception $ex){
           DB::rollBack();
           throw $ex;
       }
    }

}
