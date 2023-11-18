<?php

namespace App\Http\Resources\Tweet;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TweetResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $liked = $this->whenLoaded('likes', function () {
            return $this->likes->contains('user_id', auth()->user()->id);
        });

        return [
            'id' => $this->id,
            'content' => $this->content,
            'liked' => $liked,
            'created_at' => $this->created_at?->toDateTimeString(),
            'user' => new UserResource($this->whenLoaded('user')),
            'likes' => LikeResource::collection($this->whenLoaded('likes')),
        ];
    }
}
