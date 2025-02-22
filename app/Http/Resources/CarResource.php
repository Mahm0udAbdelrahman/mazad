<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CarResource extends JsonResource
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
            "name"=> $this->name,
            "car_type"=> $this->carType->name,
            'model'=> $this->model,
            'color'=> $this->color,
            'kilometer'=> $this->kilometer,
            'price'=> $this->price,
            'license_year'=> $this->license_year,
            'description'=> $this->description,
            'video'=> $this->video,
            'image_license'=> $this->image_license,
            'images'=> $this->carImages->pluck('image'),
            'report'=> $this->report,
            'status' => $this->status,
            'sold'=> $this->sold
        ];
    }
}
