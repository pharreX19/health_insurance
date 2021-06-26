<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriberResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            "id" => $this->id,
            "type" => "subscriber",
            "attributes" => [
                "name" => $this->name,
                "passport" => $this->passport,
                "national_id" => $this->national_id,
                "nationality" => $this->nationality,
                "contact" => $this->contact,
                "created_at" => $this->created_at,
                "updated_at" => $this->updated_at,
            ],
            "relationships" => [
                'plan_details' => $this->whenPivotLoaded('subscribers', 'plan_subscriber', function(){
                        return new PlanSubscriberResource($this->pivot);
                    }),
            ]
        ];
    }
}
