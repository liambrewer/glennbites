<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'sku' => $this->sku,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'stock_on_hand' => $this->stock_on_hand,
            'reserved_stock' => $this->reserved_stock,
            'max_per_order' => $this->max_per_order,
            'image_url' => $this->image_url,

            'available_stock' => $this->available_stock,
            'out_of_stock' => $this->out_of_stock,

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
