<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class NewsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "news_id" => $this->news_id,
			"user_id" => $this->user_id,
			"news_title" => $this->news_title,
			"news_description" => $this->news_description,
			"image" => $this->image, 
			"news_status" => $this->news_status,
			"created_at" => $this->created_at,
			"updated_at" => $this->updated_at,
			"user" => new UserResource($this->user),
            "categories" => CategoryResource::collection($this->categories)
        ];
    }
}
