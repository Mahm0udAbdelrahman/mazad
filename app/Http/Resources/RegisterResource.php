<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class RegisterResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id"=> $this->id,
            'name' =>  $this->name,
            'email'=> $this->email,
            'address' => $this->address,
            'phone'=> $this->phone,
            'national_number' => $this->national_number,
            'image' => $this->image,
            'service' => $this->service,
            'category' => $this->category,
        ];
    }
}
