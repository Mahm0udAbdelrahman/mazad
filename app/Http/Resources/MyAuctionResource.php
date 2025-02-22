<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MyAuctionResource extends JsonResource
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
            'user_name' => $this->auction->car->user->name,
            'user_image' => $this->auction->car->user->image,
            'created_at' => $this->auction->created_at,
            'images' => $this->auction->car->carImages,
            'car_name' => $this->auction->car->name,
            'report' => $this->auction->car->report,
            'description' => $this->auction->car->description,
            'end_date' => $this->auction->end_date,
            'price' => $this->price,
            'status' => $this->auction->status,
            'commit' => count($this->auction->commitAuctions),
            'phone' => $this->auction->status === 'won' ? $this->auction->car->user->phone : null,

        ];
    }
}
