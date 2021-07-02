<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Repositories\ServiceLimitGroupCalculationTypeRepository;
use App\Http\Requests\ServiceLimitGroupCalculationTypeRequest;
use Illuminate\Http\Request;

class ServiceLimitGroupCalculationTypesController extends AbstractController
{
    public function __construct(ServiceLimitGroupCalculationTypeRepository $calculationTypeRepository)
    {
        $this->repository = $calculationTypeRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ServiceLimitGroupCalculationTypeRequest $request)
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
    public function update(ServiceLimitGroupCalculationTypeRequest $request, $id)
    {
        return parent::updateItem($request->validated(), $id);
    }
}
