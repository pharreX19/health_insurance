<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Repositories\EpisodeRepository;
use App\Http\Requests\EpisodeRequest;
use Illuminate\Http\Request;

class EpisodesController extends AbstractController
{
    public function __construct(EpisodeRepository $episodeRepository)
    {
        $this->repository = $episodeRepository;
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(EpisodeRequest $request)
    {
        return parent::createItem($request->validated());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(EpisodeRequest $request, $id)
    {
        return parent::updateItem($request->validated(), $id);
    }
}
