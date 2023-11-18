<?php

namespace App\Services\Tweet;

use App\Models\Tweet;
use Illuminate\Http\JsonResponse;

class TweetService
{
    public function followingTweets(): JsonResponse
    {
        $followingTweets = auth()->user()->following()->with('tweets')->get()->pluck('tweets')->flatten();;

        return response()->json($followingTweets);
    }

    public function storeTweet(array $request): JsonResponse
    {
        $tweet = Tweet::query()->create([
            'content' => $request['content'],
            'user_id' => auth()->id()
        ]);

        return response()->json($tweet, 201);
    }

    public function getOwnTweets(): JsonResponse
    {
        $tweets = auth()->user()->tweets()->latest()->get();

        return response()->json($tweets, 201);
    }
}
