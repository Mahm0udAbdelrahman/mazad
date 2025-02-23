<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuctionResource extends JsonResource
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
            'user_id' => $this->user->id,
            'user_name' => $this->user->name,
            'user_service' => $this->user->service,
            'user_image' => $this->user->image,
            'created_at' => $this->created_at,
            'car_name' => $this->car->name,
            'sold' => $this->car->sold,
            'start_price' => $this->start_price,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'description' => $this->car->description,
            'report' => $this->car->report,
            'images' => $this->car->carImages,
            'commit' => count($this->commitAuctions),
        ];
    }
}
