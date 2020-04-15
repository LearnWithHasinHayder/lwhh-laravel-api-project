<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\UserController;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Hash;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/articles',[ArticleController::class,'getAllArticles']);
Route::get('/articles/{article}',[ArticleController::class,'getArticle']);
Route::middleware('auth:api')->group(function(){
    Route::put('/articles/{article}',[ArticleController::class,'updateArticle']);
    Route::delete('/articles/{article}',[ArticleController::class,'deleteArticle']);
});

Route::post('/articles',[ArticleController::class,'createArticle'])->middleware('auth:api');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/token',[UserController::class,'generateToken']);


Route::get('/create',function(){
    User::forceCreate([
        'name'=>'John Doe',
        'email'=>'john@doe.com',
        'password'=>Hash::make('abcd1234')
    ]);
    
    User::forceCreate([
        'name'=>'Jane Doe',
        'email'=>'jane@doe.com',
        'password'=>Hash::make('abcd1234')
    ]);
});

Route::get('/tokenc',function(){
    $user = User::find(1);
    $user->api_token = Str::random(80);
    $user->save();
    
    $user = User::find(2);
    $user->api_token = Str::random(80);
    $user->save();
    
});