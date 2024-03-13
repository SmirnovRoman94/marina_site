<?php

namespace App\Http\Resources\Patient;

use App\Http\Resources\Product\ProductResource;
use App\Http\Resources\Service\ServiceResource;
use App\Http\Resources\Service_combo\Service_comboResource;
use App\Http\Resources\User\UserResource;
use App\Models\Product;
use App\Models\Service;
use App\Models\Service_combo;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PatientResource extends JsonResource
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
            'user' => new UserResource($this->user),
            'diagnosis' => $this->diagnosis,
            'comments' => $this->comments,
            'services' => $this->services($this->services),
            'service_combos' => $this->combos($this->serviceCombos),
            'products' => $this->products($this->products),
        ];
    }

    public function combos($items)
    {
        $ids = $items->pluck('item_id');
        $services = Service_combo::whereIn('id', $ids)->get();
        return Service_comboResource::collection($services);
    }

    public function services($items)
    {
        $ids = $items->pluck('item_id');
        $services = Service::whereIn('id', $ids)->get();
        return ServiceResource::collection($services);
    }

    public function products($items)
    {
        $ids = $items->pluck('item_id');
        $services = Product::whereIn('id', $ids)->get();
        return ProductResource::collection($services);
    }
}
