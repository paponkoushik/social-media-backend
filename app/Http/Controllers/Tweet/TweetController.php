<?php

namespace App\Http\Controllers\Tweet;

use App\Http\Controllers\Controller;
use App\Http\Requests\Tweet\TweetRequest;
use App\Services\Tweet\TweetService;
use Illuminate\Http\JsonResponse;

class TweetController extends Controller
{
    protected $service;
    public function __construct(TweetService $tweetService)
    {
        $this->service = $tweetService;
    }
    public function followingTweets(): JsonResponse
    {
        return $this->service->followingTweets();
    }

    public function index(): JsonResponse
    {
        return $this->service->getOwnTweets();
    }

    public function store(TweetRequest $request): JsonResponse
    {
        return $this->service->storeTweet($request->only('content'));
    }
}
