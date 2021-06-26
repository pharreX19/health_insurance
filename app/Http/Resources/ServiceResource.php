<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // dd($this->plans);
        // dd($this->resource->relationLoaded('plans'));
        return [
            "id" => $this->id,
            "type" => "service",
            "attributes" => [
                "name" => $this->name,
                "description" => $this->description,
                "deleted_at" => $this->deleted_at,
                "created_at" => $this->created_at,
                "updated_at" => $this->updated_at,
                "limit_total"=> PlanServiceResource::collection($this->whenLoaded('plans'))
            ],
            "relationships" => [
                "plans" => PlanResource::collection($this->whenLoaded('plans')),
                "test" => PlanServiceResource::collection($this->whenLoaded('plans')),
                // "limit_total" => $this->whenPivotLoaded('plan_service', new PlanServiceResource($this->plans)),
                // "subscribers" => SubscriberResource::collection($this->whenLoaded('subscribers')),
                // "service_limit_group" =>  new ServiceLimitGroupResource($this->whenLoaded('limitGroup'))
            ]
        ];
    }
}
