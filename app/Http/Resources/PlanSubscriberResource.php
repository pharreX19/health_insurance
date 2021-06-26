<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlanSubscriberResource extends JsonResource
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
            "type" => "plan_subscriber",
            "attributes" => [
                "plan_remaining" => $this->plan_remaining,
                "begin_date" => $this->begin_date,
                "expiry_date" => $this->expiry_date
            ],
        ];
    }
}
