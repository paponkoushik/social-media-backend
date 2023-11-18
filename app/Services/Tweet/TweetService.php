<?php

namespace App\Services\Tweet;

use App\Http\Resources\Tweet\TweetResource;
use App\Models\Follower;
use App\Models\Tweet;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class TweetService
{
    protected $suggestAbleUser;
    public function followingTweets(): AnonymousResourceCollection
    {
        $followingTweets = auth()->user()
            ->following()
            ->with('tweets.user', 'tweets.likes.user')
            ->latest()
            ->get()
            ->pluck('tweets')
            ->flatten();

        return TweetResource::collection($followingTweets);
    }

    public function storeTweet(array $request): JsonResponse
    {
        $tweet = Tweet::query()->create([
            'content' => $request['content'],
            'user_id' => auth()->id()
        ]);

        return response()->json($tweet, 201);
    }

    public function getOwnTweets(): AnonymousResourceCollection
    {
        $tweets = auth()->user()
            ->tweets()
            ->with('user', 'likes.user')
            ->latest()
            ->get();

        return TweetResource::collection($tweets);
    }

    public function toggleLike(Tweet $tweet): JsonResponse
    {
        $user = auth()->user();
        if ($tweet->likes()->where('user_id', $user->id)->exists()) {
            $tweet->likes()->where('user_id', $user->id)->delete();
            $liked = false;
        } else {
            $tweet->likes()->create(['user_id' => $user->id]);
            $liked = true;
        }

        return response()->json(['liked' => $liked]);
    }

    public function suggestAbleUser(): static
    {
        $followingIds = auth()->user()->following()->pluck('users.id');
        $followersOfFollowed = Follower::whereIn('follower_id', $followingIds)->pluck('user_id');

        $this->suggestAbleUser = $followingIds->merge($followersOfFollowed);

        return $this;
    }

    public function suggestAbleUserTweets(): AnonymousResourceCollection
    {
        $tweets = Tweet::query()->whereIn('user_id', $this->suggestAbleUser)
            ->with('user', 'likes.user')
            ->latest()
            ->get();

        return TweetResource::collection($tweets);
    }
}
