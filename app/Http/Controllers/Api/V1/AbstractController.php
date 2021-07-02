<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\PlanResource;
use App\Models\Service;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Spatie\QueryBuilder\QueryBuilder;

use function PHPUnit\Framework\isEmpty;

abstract class AbstractController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $repository;
    protected $resource;

    public function index()
    {
        return $this->paginatedResponse($this->repository->index());
    }


    protected function createItem($validatedData)
    {
        return  $this->itemResponse($this->repository->store($validatedData), "Data stored successfully", Response::HTTP_CREATED);
    }


    public function show($id)
    {
        return $this->itemResponse($this->repository->show($id));
    }


    protected function updateItem($validatedData, $id){
        return $this->itemResponse($this->repository->update($validatedData, $id), "Data updated successfully");
    }


    public function destroy($id){
        $result =  $this->repository->destroy($id);
        if(is_bool($result) && $result){
            return $this->respondSuccess(null, "Requested resource deleted successfully.", Response::HTTP_NO_CONTENT);
        }
    }


    private function paginatedResponse($paginatedData, $message ="Data fetched successfully"){
        $response = [
            "data" => $paginatedData->items(),
            "meta" => [
                "current_page" => url()->current(),
                "from" => $paginatedData->firstItem(),
                "per_page" => $paginatedData->perPage(),
                "to" => $paginatedData->lastItem(),
                "has_more_pages" => $paginatedData->hasMorePages()
            ],
            "_links" => [
                "next" => $paginatedData->nextPageUrl(),
                "prev" => $paginatedData->previousPageUrl()
            ]
        ];
        if(!is_null($paginatedData->total())){
            $response["meta"] = array_merge($response["meta"], ["total" => $paginatedData->total()]);
        }

        if(count($this->repository->allowedIncludes) > 0){
            $response["meta"] = array_merge($response["meta"], ["allowed_includes" => $this->repository->allowedIncludes]);
        }
        
        return $this->respondSuccess($response, $message);
    }


    private function itemResponse($itemData, $message ="Data fetched successfully"){
        $response = [
            "data" => $itemData
        ];

        if(count($this->repository->allowedIncludes) > 0){
            $response["meta"] = [
                "allowed_includes" => $this->repository->allowedIncludes
            ];
        }
        return $this->respondSuccess($response, $message);
    }


    protected function respondSuccess($initialResponse, $message, $statusCode = Response::HTTP_OK, $headers = [])
    {
        $response =  [
            "success"=>[
                "status" => $statusCode,
                "message" => $message,
            ]
        ];

        if(isset($initialResponse)){   
            return array_merge($response , $initialResponse);
        }
        return $response;
    }


    protected function respondError($message, $statusCode = Response::HTTP_NOT_FOUND, $id = null){
        return response([
            "errors"=>[
                "status" => $statusCode,
                "code" => Response::$statusTexts[$statusCode],
                "message" => $message,
            ]
        ]);
    }
}
