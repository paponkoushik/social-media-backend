<?php

namespace App\Http\Resources\UserInfo;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FollowerFollowingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $isFollowedByAuthUser = auth()->user()->following->contains($this->id);

        return [
            'id' => $this->id,
            'username' => $this->username,
            'email' => $this->email,
            'is_followed_by_auth_user' => $isFollowedByAuthUser,
            'created_at' => $this->created_at?->format('F Y'),
        ];
    }
}
