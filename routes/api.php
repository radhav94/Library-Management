<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });



Route::group([
    'middleware' => 'api'

], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
   
    
});
Route::group(['middleware' => ['jwt.verify']], function() {
    
       // Route::get('user', 'UserController@getAuthenticatedUser');
        Route::post('/user-update/{id}', 'UserController@update'); 
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/refresh', [AuthController::class, 'refresh']);
        Route::get('/user-profile', [AuthController::class, 'userProfile']); 
        Route::post('user-delete/{id}', 'UserController@destroy'); 
        Route::get('books', 'BookController@index');
        Route::get('books/{id}', 'BookController@show');
        Route::post('book-add', 'BookController@store');
        Route::post('book-update/{id}', 'BookController@update');       
        Route::post('book-delete/{id}', 'BookController@destroy');
        Route::post('book-rent', 'RentBookController@create');
        Route::post('book-return/{transid}', 'RentBookController@update');
        Route::get('user-book/{userid}', 'RentBookController@show');

    });
