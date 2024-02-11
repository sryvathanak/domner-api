<?php

namespace App\Http\Resources\Transport;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TrainResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $includes = is_array($this->includes) ? $this->includes : [$this->includes];
        return [
            'id' =>$this ->id,
            'name' =>$this ->name,
            'price' =>$this ->price,
            'discount' =>$this ->discount,
            'star' =>$this ->star,
            'time' =>$this ->time,
            'from' =>$this ->from,
            'to' =>$this ->to,
            'code_from' =>$this ->code_from,
            'code_to' =>$this ->code_to,
            'includes' =>$includes,
            'logo' =>$this ->logo,
            
        ];
    }

    public function toOneArray(Request $request): array
    {
        $includes = is_array($this->includes) ? $this->includes : [$this->includes];
        $train_images = is_array($this->train_images) ? $this->train_images : [$this->train_images];
        return [
            'id' =>$this ->id,
            'name' =>$this ->name,
            'price' =>$this ->price,
            'discount' =>$this ->discount,
            'star' =>$this ->star,
            'time' =>$this ->time,
            'from' =>$this ->from,
            'to' =>$this ->to,
            'code_from' =>$this ->code_from,
            'code_to' =>$this ->code_to,
            'includes' =>$includes,
            'train_images' =>$train_images,
            'logo' =>$this ->logo,
            'description' =>$this ->description,
            
        ];
    }
}
