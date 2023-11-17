<?php

namespace App\Http\Controllers\Follow;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\Follow\FollowService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    protected $service;
    public function __construct(FollowService $service)
    {
        $this->service = $service;
    }

    public function follow(User $user): JsonResponse
    {
        return $this->service->follow($user);
    }

    public function unfollow(User $user): JsonResponse
    {
        return $this->service->unfollow($user);
    }

    public function ownFollowers(): JsonResponse
    {
        return $this->service->ownFollowers();
    }

    public function authFollowing(): JsonResponse
    {
        return $this->service->authFollowing();
    }
    public function userFollowers(User $user): JsonResponse
    {
        return $this->service->userFollowers($user);
    }
    public function userFollowing(User $user): JsonResponse
    {
        return $this->service->userFollowing($user);
    }
}
