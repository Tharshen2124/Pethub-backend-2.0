<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use App\Http\Resources\CommentResource;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "post_id" => $this->post_id,
			"user_id" => $this->user_id,
			"post_title" => $this->post_title,
			"post_description" => $this->post_description,
			"created_at" => $this->created_at,
			"updated_at" => $this->updated_at,
			"comments" => CommentResource::collection($this->comments),
			/* "categories" => CategoryResource::collection($this->categories) */
        ];
    }
}
