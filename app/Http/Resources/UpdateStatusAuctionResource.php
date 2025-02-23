<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UpdateStatusAuctionResource extends JsonResource
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
            'user_image' => $this->user->image,
            'winner_id'   => $this->winner->id,
            'winner_name'=> $this->winner->name,
            'winner_service'=> $this->winner->service,
            'created_at' => $this->created_at,
            'car_name' => $this->car->name,
            'price' => $this->commitAuctions->value('price'),
            'description' => $this->car->description,
            'report' => $this->car->report,
            'images' => $this->car->carImages,
            'commit' => count($this->commitAuctions),
            'status' => $this->status,
        ];
    }
}
