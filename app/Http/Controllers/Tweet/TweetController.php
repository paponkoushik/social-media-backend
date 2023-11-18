<?php

namespace App\Http\Controllers\Tweet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tweet\TweetRequest;
use App\Models\Follower;
use App\Models\Tweet;
use App\Services\Tweet\TweetService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TweetController extends Controller
{
    protected $service;
    public function __construct(TweetService $tweetService)
    {
        $this->service = $tweetService;
    }
    public function followingTweets(): AnonymousResourceCollection
    {
        return $this->service->followingTweets();
    }

    public function index(): AnonymousResourceCollection
    {
        return $this->service->getOwnTweets();
    }

    public function store(TweetRequest $request): JsonResponse
    {
        return $this->service->storeTweet($request->only('content'));
    }

    public function suggestTweets(): AnonymousResourceCollection
    {
        return $this->service->suggestAbleUser()->suggestAbleUserTweets();
    }

    public function toggleLike(Tweet $tweet): JsonResponse
    {
        return $this->service->toggleLike($tweet);
    }
}
