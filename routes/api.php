<?php

use Illuminate\Http\Request;

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
Route::group(['middleware' => ['jwt.auth','api-header']], function () {

    // all routes to protected resources are registered here
    Route::get('users/list', function(){
        $users = App\User::all();

        $response = ['success'=>true, 'data'=>$users];
        return response()->json($response, 201);
    });
});
Route::group(['middleware' => 'api-header'], function () {

    // The registration and login requests doesn't come with tokens
    // as users at that point have not been authenticated yet
    // Therefore the jwtMiddleware will be exclusive of them
    Route::post('user/login', 'Api\UserController@login');
    Route::post('user/register', 'Api\UserController@register');
});
Route::get('task/complete', 'Api\TaskController@complete');
Route::get('student/delete_event', 'Api\StudentController@deleteEvent');
Route::get('student/delete_letter', 'Api\StudentController@deleteLetter');
Route::get('student/absences', 'Api\StudentController@getAbsences');
Route::get('student/tardies', 'Api\StudentController@getTardiesAndEDs');
Route::resource('import', 'Api\ImportController');
Route::resource('student', 'Api\StudentController');
Route::resource('task', 'Api\TaskController');
