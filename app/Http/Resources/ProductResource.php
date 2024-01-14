<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        return [
            'name' => $this->name,
            'description' => $this->description,
            'category' => CategoryResource::make($this->whenLoaded('category')),
            'date_and_time' => $this->date_and_time->format('M d, Y')
        ];
    }
}
