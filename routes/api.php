<?php

use App\Http\Controllers\API\AuthenticationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
 * |--------------------------------------------------------------------------
 * | API Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register API routes for your application. These
 * | routes are loaded by the RouteServiceProvider within a group which
 * | is assigned the "api" middleware group. Enjoy building your API!
 * |
 */


// Handle User Authentication
Route::group(['prefix' => 'authentication', 'namespace' => 'API', 'as' => 'authentication.'], function () {
    Route::post('/signin', [AuthenticationController::class, 'signin'])->name('signin');
    Route::post('/signup', [AuthenticationController::class, 'signup'])->name('signup');

    Route::post('/subscribe', [AuthenticationController::class, 'subscribe'])->name('subscribe');
    Route::post('/resendPincode', [AuthenticationController::class, 'resendCode'])->name('resendCode');

    Route::post('/forgotPassword', [AuthenticationController::class, 'forgotPassword'])->name('forgotPassword');
    Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');

    Route::post('/refreshToken', [AuthenticationController::class, 'refreshToken'])->name('refreshToken');
});

Route::group(['prefix' => 'v1', 'namespace' => 'API'], function () {
    Route::get('/', 'AndroidApiController@index');

    Route::post('dashboard', 'AndroidApiController@dashboard');
    Route::post('profile', 'AndroidApiController@profile');
    Route::post('profile_update', 'AndroidApiController@profile_update');
    Route::post('account_delete', 'AndroidApiController@account_delete');

    Route::post('home', 'AndroidApiController@home');
    Route::post('home_collections', 'AndroidApiController@home_collections');
    Route::post('genres', 'AndroidApiController@genres');

    Route::post('shows', 'AndroidApiController@shows');
    Route::post('shows_by_language', 'AndroidApiController@shows_by_language');
    Route::post('shows_by_genre', 'AndroidApiController@shows_by_genre');

    Route::post('show_details', 'AndroidApiController@show_details');
    Route::post('seasons', 'AndroidApiController@seasons');
    Route::post('episodes', 'AndroidApiController@episodes');
    Route::post('episodes_recently_watched', 'AndroidApiController@episodes_recently_watched');
    // Route::post('episodes_details', 'AndroidApiController@episodes_details');

    Route::post('movies', 'AndroidApiController@movies');
    Route::post('movies_by_language', 'AndroidApiController@movies_by_language');
    Route::post('movies_by_genre', 'AndroidApiController@movies_by_genre');
    Route::post('movies_details', 'AndroidApiController@movies_details');

    Route::post('sports_category', 'AndroidApiController@sports_category');
    Route::post('sports', 'AndroidApiController@sports');
    Route::post('sports_by_category', 'AndroidApiController@sports_by_category');
    Route::post('sports_details', 'AndroidApiController@sports_details');

    Route::post('livetv_category', 'AndroidApiController@livetv_category');
    Route::post('livetv', 'AndroidApiController@livetv');
    Route::post('livetv_by_category', 'AndroidApiController@livetv_by_category');
    Route::post('livetv_details', 'AndroidApiController@livetv_details');

    Route::post('search', 'AndroidApiController@search');

    Route::post('my_watchlist', 'AndroidApiController@my_watchlist');
    Route::post('watchlist_add', 'AndroidApiController@watchlist_add');
    Route::post('watchlist_remove', 'AndroidApiController@watchlist_remove');

    Route::post('apply_coupon_code', 'AndroidApiController@apply_coupon_code');

    Route::post('actor_details', 'AndroidApiController@actor_details');
    Route::post('director_details', 'AndroidApiController@director_details');
});
