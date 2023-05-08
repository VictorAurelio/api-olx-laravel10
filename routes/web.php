<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\JsonResponse;

/*
 * - Utilities routes
 * [x] - /ping - answer PONG
 *
 * - Authentication routes via Token
 * [] - /user/signin - user signin
 * [] - /user/signup - user signup
 * [] - /user/me - user profile
 *
 * - Generic routes
 * [x] - /states - list all states
 * [x] - /categories - list all categories
 *
 * - Advertisements routes
 * [] - /ad/list - list all advertisements
 * [] - /ad/:id - show a specific advertisement
 * [] - /ad/add - add a new advertisement
 * [] - /ad/:id (PUT) - update an existing advertisement
 * [] - /ad/:id (DELETE) - delete an existing advertisement
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

/*
 *  Authentication routes
 */

Route::post('user/signup', [\App\Http\Controllers\Auth\AuthController::class, 'signUp']);
Route::post('user/signin', [\App\Http\Controllers\Auth\AuthController::class,'signIn']);
Route::post('user/signout', [\App\Http\Controllers\Auth\AuthController::class,'signOut']);
Route::get('user/me', [\App\Http\Controllers\Auth\AuthController::class,'userProfile'])
    ->middleware('auth:sanctum');
