<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\JsonResponse;

/*
 * - Utilities routes
 * [x] - /ping - answer PONG
 *
 * - Authentication routes via Token
 * [x] - /user/signin - user signin
 * [x] - /user/signup - user signup
 * [x] - /user/me - user profile
 *
 * - Generic routes
 * [x] - /states - list all states
 * [x] - /categories - list all categories
 *
 * - Advertisements routes
 * [x] - /ad/list - list all advertisements
 * [x] - /ad/:id - show a specific advertisement
 * [x] - /ad/add - add a new advertisement
 * [x] - /ad/:id (PUT) - update an existing advertisement
 * [x] - /ad/:id (DELETE) - delete an existing advertisement
 * [] - /ad/:id/:image - show an image
 *
 * **/

/*
 *  Utilities routes
 */

Route::get('/ping', function(): JsonResponse {
    return response()->json(['Pong' => true]);
});

/*
 *  Generic routes
 */

Route::get('/states', [\App\Http\Controllers\Generics\StatesController::class, 'index']);
Route::get('/categories', [\App\Http\Controllers\Generics\CategoriesController::class, 'index']);

/*
 *  Advertisements routes
 */

Route::get('/ad/list', [\App\Http\Controllers\Advertisements\AdvertisementController::class, 'index']);
Route::get('/ad/{id}', [\App\Http\Controllers\Advertisements\AdvertisementController::class, 'showAdvertisement']);
Route::post('/ad/add', [\App\Http\Controllers\Advertisements\AdvertisementController::class, 'createAdvertisement']);
Route::delete('/ad/{id}', [\App\Http\Controllers\Advertisements\AdvertisementController::class, 'deleteAdvertisement']);
Route::put('/ad/{id}', [\App\Http\Controllers\Advertisements\AdvertisementController::class, 'updateAdvertisement']);

/*
 *  Authentication routes
 */

Route::post('user/signup', [\App\Http\Controllers\Auth\AuthController::class, 'signUp']);
Route::post('user/signin', [\App\Http\Controllers\Auth\AuthController::class,'signIn']);
Route::post('user/signout', [\App\Http\Controllers\Auth\AuthController::class,'signOut']);
Route::get('user/me', [\App\Http\Controllers\Auth\AuthController::class,'userProfile'])
    ->middleware('auth:sanctum');
