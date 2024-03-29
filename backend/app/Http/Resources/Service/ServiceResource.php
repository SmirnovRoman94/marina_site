<?php

namespace App\Http\Resources\Service;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ServiceResource extends JsonResource
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
            'description' => $this->description,
            'form' => $this->form,
            'duration' => $this->duration,
            'preview' => $this->preview,
            'price' => $this->price,
            'count' => $this->countService(),
            'image' => $this->getFirstMediaUrl('images'),
            'type' => 'Service'
        ];
    }
}
