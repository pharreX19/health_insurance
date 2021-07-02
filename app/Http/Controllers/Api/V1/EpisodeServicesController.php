<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\Episode;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Requests\EpisodeServiceRequest;
use App\Http\Repositories\EpisodeServicesRepository;

class EpisodeServicesController extends AbstractController
{
    public function __construct(EpisodeServicesRepository $episodeServicesRepository)
    {
        $this->repository = $episodeServicesRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EpisodeServiceRequest $request)
    {
        $result = $this->repository->addServiceToEpisode($request->validated());
        return $this->respondSuccess(null, "Service added to episode successfully", Response::HTTP_CREATED);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EpisodeServiceRequest $request, $id)
    {
        $result = $this->repository->updateServiceOnEpisode($request->validated(), $id);
        return $this->respondSuccess(null, "Service on episode updated successfully", Response::HTTP_OK);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = $this->repository->removeServiceFromEpisode($id);
        return $this->respondSuccess(null, "Service removed from episode successfully", Response::HTTP_NO_CONTENT);
    }
}
