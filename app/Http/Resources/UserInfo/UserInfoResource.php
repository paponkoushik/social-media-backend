<?php

namespace App\Http\Resources\UserInfo;

use App\Http\Resources\Tweet\TweetResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserInfoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'created_at' => $this->created_at?->format('F Y'),
            'followers' => FollowerFollowingResource::collection($this->whenLoaded('followers')),
            'following' => FollowerFollowingResource::collection($this->whenLoaded('following')),
            'tweets' => TweetResource::collection($this->whenLoaded('tweets')),
        ];
    }
}
