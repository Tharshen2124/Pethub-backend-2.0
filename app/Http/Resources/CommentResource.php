<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "comment_id" => $this->comment_id,
            "user_id" => $this->user_id,
            "post_id" => $this->post_id,
            "comment_description" => $this->comment_description,
            "updated_at" => $this->updated_at,
            "user" => new UserResource($this->user)
        ];
    }
}
