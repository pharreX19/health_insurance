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
use Illuminate\Validation\ValidationException;

class PlanServiceLimitGroupRepository extends BaseRepository
{

    protected $repository;

    public function __construct()
    {
        $this->model = PlanServiceLimitGroup::class;
        $this->repository = new ServiceLimitGroupRepository();
    }


    public function addServiceLimitGroupToPlan($plan, $validatedData)
    {
        foreach($validatedData as $data){
            $serviceLimitGroup = $this->repository->show($data['service_limit_group_id']);
            if(!$this->serviceLimitGroupExistsOnPlan($plan, $serviceLimitGroup)){
                $this->serviceToPlan($plan, $serviceLimitGroup, $data);
            }else{
                throw ValidationException::withMessages([
                    'message' => 'Service limit group already present in this plan'
                ]);
            }
        }
    }


    public function updateServiceLimitGroupOnPlan($plan, $validatedData){
        foreach($validatedData as $data){
            $serviceLimitGroup = $this->repository->show($data['service_limit_group_id']);
            if($this->serviceLimitGroupExistsOnPlan($plan, $serviceLimitGroup)){
                $this->detachService($plan, $serviceLimitGroup);
                $this->serviceToPlan($plan, $serviceLimitGroup, $data);
            }
        }
    }


    // public function removeServiceLimitGroupFromPlan($plan, $serviceLimitGroup)
    // {
    //     $result = $this->serviceLimitGroupExistsOnPlan($plan, $serviceLimitGroup);
    //     return DB::transaction(function () use ($serviceLimitGroup, $plan){
    //         $plan->services()->updateExistingPivot($serviceLimitGroup->id, [
    //             "deleted_at" => Carbon::now()
    //         ]);
    //     });
    // }


    private function serviceLimitGroupExistsOnPlan($plan, $serviceLimitGroup){
        return $plan->serviceLimitGroups()->wherePivot('service_limit_group_id', $serviceLimitGroup->id)->exists();
    }

    // public function serviceLimitGroupExistsOnPlan()
    // {
        
    // }


    private function detachService($plan, $serviceLimitGroup){
        return DB::transaction(function () use ($serviceLimitGroup, $plan){
            $plan->serviceLimitGroups()->detach($serviceLimitGroup->id);
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
