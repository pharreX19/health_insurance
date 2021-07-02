<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Repositories\PolicyRepository;
use App\Http\Requests\PolicyRequest;
use Illuminate\Http\Request;

class PoliciesController extends AbstractController
{
    public function __construct(PolicyRepository $policyRepository)
    {
        $this->repository = $policyRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PolicyRequest $request)
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
    public function update(PolicyRequest $request, $id)
    {
        return parent::updateItem($request->validated(), $id);
    }
}
