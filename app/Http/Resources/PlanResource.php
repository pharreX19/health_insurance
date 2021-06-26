<?php

namespace App\Http\Resources;

use App\Http\Resources\ServiceResource;
use App\Http\Resources\SubscriberResource;
use App\Models\PlanSubscriber;
use Illuminate\Http\Resources\Json\JsonResource;

class PlanResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {   
        // dd($this->subscribers->first->pivot->pivot->plan_remaining);
        // dd($this->subscribers->first()->pivot->plan_remaining);
        // $this->load('plan_subscribers');
        // dd($this->resource->relationLoaded('subscribers.plan_subscribers'));
        return [
            "id" => $this->id,
            "type" => "plan",
            "attributes" => [
                "name" => $this->name,
                "limit_total" => $this->limit_total,
                "territorial_limit" => $this->territorial_limit,
                "currency" => $this->currency,
                "created_at" => $this->created_at,
                "updated_at" => $this->updated_at,
            ],
            "relationships" => [
                "subscribers" => SubscriberResource::collection($this->whenLoaded('subscribers')),
                "services" => ServiceResource::collection($this->whenLoaded('services')),
                // 'plan_details' => $this->whenPivotLoaded('subscribers', 'plan_subscribers', function(){
                //     return PlanSubscriberResource::collection($this->subscribers);
                // }),
            ]
        ];
    }

    public function with($request)
    {
        return [
            'meta' => [
                'success' => 'true',
            ],
        ];
    }

}
