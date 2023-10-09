<?php

use App\Http\Controllers\MyNfcController;
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\CIOTDeviceController;
use App\Http\Controllers\DeviceLogController;
use Illuminate\Http\Request;
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
Route::get('/test',function(){
return 'test';
});

Route::get('news/fetchAll','NewsController@fetchAll');


Route::get('nfc-cards/user/{id}', [MyNfcController::class, 'getMyNfcCard']);
Route::post('nfc-cards/new', [MyNfcController::class, 'create']);
Route::get('nfc-cards/{id}', [MyNfcController::class, 'read']);
Route::put('nfc-cards/{id}', [MyNfcController::class, 'update']);
Route::any('nfc-cards/{id}/delete', [MyNfcController::class, 'delete']);

Route::any('iot/open-door', [CIOTDeviceController::class, 'openDoor']);
Route::any('iot-close-door', [CIOTDeviceController::class, 'closeDoor']);
Route::any('iot/turn-on-lamp', [CIOTDeviceController::class, 'turnOnLamp']);
Route::any('iot/turn-off-lamp', [CIOTDeviceController::class, 'turnOffLamp']);


Route::any('log/store', [DeviceLogController::class, 'store']);

Route::post('people/register','PeopleController@store');
Route::post('people/login','PeopleController@login');


Route::post('people/{id}/change-password','PeopleController@changePassword');
Route::any('people/{id}','PeopleController@getUserByID');
Route::any('people/{id}/update','PeopleController@updateUserByID');
Route::post('people/{id}/update_photo','PeopleController@updatePhotoByID');

Route::get('category','ReportCategoryController@getCategory');
Route::post('category/store','ReportCategoryController@store');
Route::any('category/{id}/delete','ReportCategoryController@destroy');
Route::post('category/{id}/update','ReportCategoryController@update');

Route::post('report/store','ReportController@store');
Route::any('report/users/{id}','ReportController@getByUsers');
Route::delete('report/{id}/delete','ReportController@delete');
Route::get('report/{id}/detail','ReportController@getByID');
Route::post('report/{id}/store-response','ResponseController@store');


Route::post('response/store','ReportController@store');
Route::any('report/users/{id}','ReportController@getByUsers');
Route::delete('report/{id}/delete','ReportController@delete');
Route::get('report/{id}/detail','ReportController@getByID');


Route::post('news/store','NewsController@store');
Route::delete('news/{id}/delete','NewsController@destroy');

Route::post('hospital/store','HospitalController@store');
Route::any('hospital/fetch','HospitalController@fetch');
Route::post('hospital/{id}/update','HospitalController@update');
Route::delete('hospital/{id}/delete','HospitalController@delete');
Route::get('hospital/{id}/detail','HospitalController@getByID');

Route::post('contact/store','ContactController@store');
Route::any('contact/fetch','ContactController@fetch');
Route::post('hospital/{id}/update','HospitalController@update');
Route::delete('contact/{id}/delete','ContactController@delete');
Route::get('contact/{id}/detail','ContactController@getByID');


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::prefix('people')->group(function(){
    Route::get('/fetch/all','PeopleController@fetchAll');
});


