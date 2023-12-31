<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Follow\FollowController;
use App\Http\Controllers\Tweet\TweetController;
use App\Http\Controllers\User\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\Router;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(['prefix' => 'auth/'], function (Router $router) {

    $router->post('login', [AuthController::class, 'login'])
        ->name('login');

    $router->post('logout', [AuthController::class, 'logout'])
        ->name('logout');

    $router->middleware('jwt.authenticate')
        ->post('refresh', [AuthController::class, 'refresh'])
        ->name('refresh');

    $router->middleware('auth:api')
        ->get('myself', [AuthController::class, 'mySelf'])
        ->name('myself');
});

Route::middleware('jwt.auth')->group(function (Router $router) {
    $router->post('follow/{user}', [FollowController::class, 'follow'])
        ->name('follow');

    $router->post('unfollow/{user}', [FollowController::class, 'unfollow'])
        ->name('unfollow');

    $router->get('followers', [FollowController::class, 'ownFollowers'])
        ->name('followers');

    $router->get('following', [FollowController::class, 'authFollowing'])
        ->name('following');

    $router->get('followers/{user}', [FollowController::class, 'userFollowers'])
        ->name('followers');

    $router->get('following/{user}', [FollowController::class, 'userFollowing'])
        ->name('following');

    $router->post('/tweet', [TweetController::class, 'store'])
        ->name('postTweet');

    $router->get('tweets', [TweetController::class, 'index'])
        ->name('getTweets');

    $router->get('following-tweets', [TweetController::class, 'followingTweets'])
        ->name('followingTweets');

    $router->get('suggest-tweets', [TweetController::class, 'suggestTweets'])
        ->name('suggestTweets');

    $router->post('tweet/{tweet}/like', [TweetController::class, 'toggleLike'])
        ->name('toggleLike');

    $router->get('users', [UserController::class, 'index'])
        ->name('searchUsers');

    $router->get('get-user-info/{user}', [UserController::class, 'show'])
        ->name('showUser');
});
