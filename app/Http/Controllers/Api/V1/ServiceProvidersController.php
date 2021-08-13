<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Repositories\ServiceProviderRepository;
use App\Http\Requests\ServiceProviderRequest;
use Illuminate\Http\Request;

class ServiceProvidersController extends AbstractController
{
    public function __construct(ServiceProviderRepository $serviceProviderRepository)
    {
        $this->repository = $serviceProviderRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceProviderRequest $request)
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
    public function update(ServiceProviderRequest $request, $id)
    {
        return parent::updateItem($request->validated(), $id);
    }
}
