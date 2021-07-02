<?php

namespace App\Http\Repositories;

use Exception;
use Carbon\Carbon;
use App\Models\Plan;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\EpisodeService;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\QueryBuilder;
use App\Http\Repostories\RepositoryInterface;
use App\Models\Episode;
use Illuminate\Validation\ValidationException;

class EpisodeServicesRepository extends BaseRepository
{

    public function __construct()
    {
        $this->model = EpisodeService::class;
        $this->allowedIncludes = [];

    }

    public function addServiceToEpisode($validatedData)
    {
        $episode = $this->getEpisode($validatedData["episode_id"]);
        return $this->serviceToEpisode($episode, $validatedData);
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
    

    private function getEpisode($episodeId){
        $episode =  Episode::findOrFail($episodeId);
        if($episode->status === "completed"){
            throw ValidationException::withMessages([
                "episode" => "Episode has been settled"
            ]);
        }
        return $episode;
    }

    private function serviceToEpisode($episode, $validatedData){
        try{
            DB::transaction(function () use ($episode, $validatedData){
                return $episode->services()->attach($validatedData['service_id'],[
                    'insurance_covered_limit' => $validatedData['insurance_covered_limit'],
                    'aasandha_covered_limit' => $validatedData['aasandha_covered_limit'],
                    'self_covered_limit' => $validatedData['self_covered_limit'],
                ]);
            });
        }catch(Exception $ex){
            throw $ex;
        }
    }
}
