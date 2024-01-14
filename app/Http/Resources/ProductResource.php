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
            'id' => $this->id,
            'name' => $this->name,
            'category_id' => $this->category_id,
            'description' => $this->description,
            'category' => CategoryResource::make($this->whenLoaded('category')),
            'date_and_time' => $this->date_and_time->format('Y-m-d\TH:i'),
            'images' => $this->when(
                $this->relationLoaded('media'),
                function () {
                    return $this->media
                        ->map(fn ($image) => $image->getUrl());
                }
            ),
        ];
    }
}
