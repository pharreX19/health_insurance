<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PlanServiceResource extends JsonResource
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
            "type" => "plan_services",
            "id" => $this->id,
            "attributes" => [
                "plan" => $this->name,
                "limit_total"=> $this->pivot->limit_total
            ]
        ];
    }
}
