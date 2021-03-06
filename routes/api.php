<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('version', function () {
    return response()->json(['version' => config('app.version')]);
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    Log::debug('User:' . serialize($request->user()));
    return $request->user();
});


Route::namespace('App\\Http\\Controllers\\API\V1')->group(function () {
    Route::get('profile', 'ProfileController@profile');
    Route::put('profile', 'ProfileController@updateProfile');
    Route::post('change-password', 'ProfileController@changePassword');

    Route::get('tag/list', 'TagController@list');
    Route::get('service/list', 'ServiceController@list');
    Route::get('category/list', 'CategoryController@list');

    Route::get('service-request/recieved', 'ServiceRequestController@recieved');
    Route::get('service-request/recieved/rejected', 'ServiceRequestController@recievedAndRejected');
    Route::get('service-request/recieved/approved', 'ServiceRequestController@recievedAndApproved');

    Route::get('service-request/sent', 'ServiceRequestController@sent');
    Route::get('service-request/sent/rejected', 'ServiceRequestController@sentAndRejected');
    Route::get('service-request/sent/approved', 'ServiceRequestController@sentAndApproved');

    Route::post('product/upload', 'ProductController@upload');

    Route::apiResources([
        'user' => 'UserController',
        'product' => 'ProductController',
        'role' => 'RoleController',
        'service' => 'ServiceController',
        'serviceRequest' => 'ServiceRequestController',
        'feedback' => 'FeedbackController',
        'complain' => 'ComplainController',
        'category' => 'CategoryController',
        'tag' => 'TagController',
    ]);
});
