<?php

namespace App\Services\Follow;

use App\Models\User;
use Illuminate\Http\JsonResponse;

class FollowService
{
    public function follow(User $user): JsonResponse
    {
        auth()->user()->follow($user);

        return response()->json(['message' => 'Followed to the user'], 200);
    }

    public function unfollow(User $user): JsonResponse
    {
        auth()->user()->unfollow($user);

        return response()->json(['message' => 'Unfollowed the user'], 200);
    }

    public function ownFollowers(): JsonResponse
    {
        $followers = User::with('followers')->find(auth()->user()->id);
        return response()->json(['followers' => $followers]);
    }
    public function authFollowing(): JsonResponse
    {
        $following = User::with('following')->find(auth()->user()->id);
        return response()->json(['followers' => $following]);
    }

    public function userFollowers(User $user): JsonResponse
    {
        $followers = User::with('followers')->find($user->id);
        return response()->json(['followers' => $followers]);
    }
    public function userFollowing(User $user): JsonResponse
    {
        $following = User::with('following')->find($user->id);
        return response()->json(['followers' => $following]);
    }
}
