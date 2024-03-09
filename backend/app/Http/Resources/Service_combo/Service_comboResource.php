<?php

namespace App\Http\Resources\Service_combo;

use App\Http\Resources\Service\ServiceForComboResource;
use App\Http\Resources\Service\ServiceResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class Service_comboResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'old_price' => $this->old_price,
            'discount' => $this->discount,
            'count_level' => $this->count_level,
            'level' => $this->level,
            'price' => $this->resultPrice(),
            'image' => $this->getFirstMediaUrl('images'),
            'services' => ServiceForComboResource::collection($this->services)
        ];
    }
}
