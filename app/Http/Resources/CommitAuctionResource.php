<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommitAuctionResource extends JsonResource
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
            'user_name' => $this->user->name,
            'user_image' => $this->user->image,
            'car_name' => $this->auction->car->name,
            'price' => $this->price,
            'commit' => $this->commit ?? null,
            'created_at' => $this->created_at,
        ];
    }
}
