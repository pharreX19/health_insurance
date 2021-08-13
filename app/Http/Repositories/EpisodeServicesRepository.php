<?php

namespace App\Http\Repositories;

use Exception;
use Carbon\Carbon;
use App\Models\Plan;
use App\Models\Company;
use App\Models\Episode;
use App\Models\Service;
use App\Models\Subscriber;
use Illuminate\Http\Request;
use App\Models\EpisodeService;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Repostories\RepositoryInterface;
use App\Http\Services\PlanSubscriptionService;
use App\Http\Services\ServiceSubscriptionService;
use Illuminate\Validation\ValidationException;

class EpisodeServicesRepository extends BaseRepository
{

    private $serviceSubscriptionService;

    public function __construct()
    {
        $this->model = EpisodeService::class;
        $this->allowedIncludes = [];
        $this->serviceSubscriptionService = new ServiceSubscriptionService();
    }

    public function addServiceToEpisode($validatedData)
    {
        foreach($validatedData as $data){
            $episode = $this->getEpisode($data["episode_id"]);
            $this->serviceToEpisode($episode, $data);
        }
        return true;
    }


    public function updateServiceOnEpisode($validatedData, $id)
    {
        $serviceEpisode = $this->find($id);
        $episode = $this->getEpisode($serviceEpisode->episode_id);
        return parent::update($validatedData, $id);
    }


    public function removeServiceFromEpisode($id)
    {
        $serviceEpisode = $this->find($id);
        $episode = $this->getEpisode($serviceEpisode->episode_id);
        return parent::destroy($id);
    }


    private function getEpisode($episodeId)
    {
        $episode =  Episode::findOrFail($episodeId);
        if ($episode->status === "completed") {
            throw ValidationException::withMessages([
                "episode" => "Episode has been settled"
            ]);
        }
        return $episode;
    }

    private function getSubscriber($subscriberId)
    {
        return Subscriber::findOrFail($subscriberId);
    }

    private function getService($serviceId)
    {
        return Service::findOrFail($serviceId);
    }

    private function serviceToEpisode($episode, $validatedData)
    {
        // $subscriber = $this->getSubscriber($episode->subscriber_id);
        // $service = $this->getService($validatedData['service_id']);
        
        // $currentSubscription = (new PlanSubscriptionService($subscriber->subscriptions()->getRelated()))->validSubscription($subscriber->id, $subscriber->plan_id);     
        
        // dd( $this->serviceSubscriptionService->getPlanServiceLimit($currentSubscription->plan, $service, $currentSubscription));
        // if ($currentSubscription && $this->serviceSubscriptionService->serviceExistsOnPlan($currentSubscription->plan, $service)) {
            
            $result = $this->serviceSubscriptionService->getPlanServiceLimit($validatedData['service_id'], $episode->subscriber_id);//$currentSubscription->plan, $service, 
            // $currentSubscription);
        
            if(!$result['service_limit']){
                $result['service_limit'] = isset($validatedData['limit_total']) ? $validatedData['limit_total'] : null;
                $result['insurance_covered_limit'] = $result['service_limit'] > $result['insurance_covered_limit'] ? $result['insurance_covered_limit'] : $result['service_limit'];

                if(!$result['service_limit']){
                    throw ValidationException::withMessages([
                        'message' => 'Service limit total is required'
                    ]);
                }
            }
            if($result['service_limit'] > $result['insurance_covered_limit'] + ($validatedData['aasandha_covered_limit'] ?? 0) + ($validatedData['self_covered_limit'] ?? 0)){
                throw ValidationException::withMessages([
                    'message' => 'Service price exceeds the payment',
                    // 'insurance' => 'Insurance covered for this service is MVR '.$result['insurance_covered_limit']
                ]);
            }else if($result['service_limit'] < $result['insurance_covered_limit'] + ($validatedData['aasandha_covered_limit'] ?? 0) + ($validatedData['self_covered_limit'] ?? 0)){
                throw ValidationException::withMessages([
                    'message' => 'Payment exceeds the service price',
                    // 'insurance' => 'Insurance covered for this service is MVR '.$result['insurance_covered_limit'] 
                ]);
            }

// dd($result['current_subscription']);
            try {
                DB::beginTransaction();

                // DB::transaction(function () use ($episode, $validatedData){
                    // dd($planServiceLimit);
                    if(isset($result['current_subscription'])){
                        $subscription = $result['current_subscription'];//->subscriptions()->latest()->first();
                        $subscription->plan_remaining -= $result['insurance_covered_limit'];
                        $subscription->save();
                    }
                
                $episode->services()->attach($validatedData['service_id'], [
                    'insurance_covered_limit' => $result['insurance_covered_limit'],
                    'aasandha_covered_limit' => $validatedData['aasandha_covered_limit'] ?? 0,
                    'self_covered_limit' => $validatedData['self_covered_limit'] ?? 0,
                ]);
                DB::commit();
                // });
            } catch (Exception $ex) {
                throw $ex;
            // }
        }
    }
}
