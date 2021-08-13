<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Repositories\CompanyRepository;
use Illuminate\Http\Response;
use App\Http\Resources\PlanResource;
use Illuminate\Database\Eloquent\Model;
use App\Http\Repositories\PlanRepository;
use App\Http\Repositories\ServiceLimitGroupRepository;
use App\Http\Repositories\ServiceRepository;
use App\Http\Requests\CompanyRequest;
use App\Http\Requests\PlanRequest;
use App\Http\Requests\ServiceLimitGroupRequest;
use App\Http\Requests\ServiceRequest;
use ArrayAccess;

class CompaniesController extends AbstractController
{

    public function __construct(CompanyRepository $companyRepository)
    {
        $this->repository = $companyRepository;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CompanyRequest $request)
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
    public function update(CompanyRequest $request, $id)
    {
        return parent::updateItem($request->validated(), $id);
    }

    public function search($registration){
        return $this->respondSuccess(["data" => $this->repository->search($registration)], "Record fetched successfully");
    }
}
