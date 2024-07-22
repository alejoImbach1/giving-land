<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
    
    Route::get('/logout',[AuthController::class,'logout']);
    
    Route::apiSingleton('profile',ProfileController::class)->only('update');
});
// Route::post('/register', [AuthController::class, 'register'])->middleware('guest');
Route::post('/login', [AuthController::class, 'login']);

// Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');


Route::apiResource('posts',PostController::class);


Route::get('profile-image/{profile}',function ($id){
    // $path = env('app_url') . ;
    $profile = Profile::find($id);
    $url = ($profile->google_avatar) ? $profile->google_avatar: env('app_url') . '/storage/users_profile_images/' . $profile->image->url;

    return response()->json($url);
});

Route::resource('profiles', ProfileController::class)->only('show')->parameter('profiles','user');

Route::get('/prueba',function (){
    return response()->json(['user' => auth()->user()]);
});