<?php

namespace App\Http\Repositories;

use Exception;
use Carbon\Carbon;
use App\Models\Plan;
use App\Models\PlanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Repostories\RepositoryInterface;
use App\Http\Services\ServiceSubscriptionService;

class PlanServiceRepository extends BaseRepository
{

    public function __construct()
    {
        $this->model = PlanService::class;
    }


    public function addServiceToPlan($validatedData, $plan, $service)
    {
        $result = (new ServiceSubscriptionService())->serviceDoesNotExistOnPlan($plan, $service);
        return $this->serviceToPlan(...func_get_args());
    }

    public function updateServiceOnPlan($validatedData, $plan, $service){
        $result = (new ServiceSubscriptionService())->serviceExistsOnPlan($plan, $service);
        $this->detachService($plan, $service);
        return $this->serviceToPlan(...func_get_args());
    }

    public function removeServiceFromPlan($plan, $service)
    {
        $result = (new ServiceSubscriptionService())->serviceExistsOnPlan($plan, $service);
        return DB::transaction(function () use ($service, $plan){
            $plan->services()->updateExistingPivot($service->id, [
                "deleted_at" => Carbon::now()
            ]);
        });
    }


    private function detachService($plan, $service){
        return DB::transaction(function () use ($service, $plan){
            $plan->services()->detach($service->id);
        });
    }


    private function serviceToPlan($validatedData, $plan, $service)
    {
       try{
        DB::beginTransaction();
        $plan->services()->attach($service->id, [
            "limit_total" => $validatedData["limit_total"] ?? null,
            "limit_group_calculation_type_id" => $validatedData["limit_group_calculation_type_id"] ?? null,
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
