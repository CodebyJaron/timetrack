<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HourResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'amount' => $this->amount,
            'date' => $this->date,
            'note' => $this->note,
            'companyId' => $this->company_id,
            'userId' => $this->user_id,
        ];
    }
}
