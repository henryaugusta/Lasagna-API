<?php

use Illuminate\Support\Facades\Route;


Route::post('/group/store','AdminGroupController@store');
Route::post('/group/change_mentor','AdminGroupController@changeMentor');
Route::post('/group/delete','AdminGroupController@delete');

Route::post('/guru/adminInsert','GuruController@adminInsert');
Route::delete('/guru/{id}/adminDelete','GuruController@deleteAjax');

Route::get('/group/{id}/detail','GroupController@viewDetail');

Route::group(['prefix' => 'post', 'middleware' => ['auth']], function(){
    Route::get('all','Controller@post');
    Route::get('user','Controller@post');    
});

Route::group(['prefix'=>'admin','middleware' => ['admin']], function () {
    Route::view('/data/santri/import','admin.santri.import');
    Route::view('/data/guru/import','admin.guru.import');
    Route::get('/data/mutabaah/create','MutabaahController@viewAdminCreate');
    Route::any('/data/mutabaah/manage','MutabaahController@viewAdminManage');
    Route::any('/data/mutabaah/preview','MutabaahController@viewAdminPreview');

    Route::any('/data/mp3','Mp3StreamingController@viewAdminPreview');
    Route::any('/data/mp3/store','Mp3StreamingController@store')->name('admin.upload.mp3');

    Route::post('/data/mutabaah/report/check','AdminReportMutabaahController@viewCheck')->name('admin.mutabaah.search_filter_all');
    Route::get('/data/mutabaah/report/check','AdminReportMutabaahController@viewCheck');


    Route::any('/data/group/create','AdminGroupController@viewAdminCreate');
    Route::any('/data/group/manage','AdminGroupController@viewAdminManage');
 

    Route::any('/data/santri/manage','SantriController@viewAdminManage');
    Route::any('/data/santri/{id}/edit','SantriController@viewAdminEdit');

    Route::any('/data/guru/manage','GuruController@viewAdminManage');
    Route::any('/data/guru/{id}/edit','GuruController@viewAdminEdit');

    
    Route::get('/','HomeAdminController@index');


});

Route::post('/santri/import','DataController@importExcelSantri')->name('import_santri');
Route::post('/guru/import','DataController@importExcelGuru')->name('import_guru');

Route::post('/santri/update','SantriController@update');
Route::delete('/santri/{id}/deleteAjax','SantriController@deleteAjax');


Route::post('/mutabaah/store','MutabaahController@store');

Route::get('/mutabaah/eloquent','MutabaahController@testEloquent');
Route::get('/mutabaah/{id}/fetch','MutabaahController@getById');
Route::post('/mutabaah/{id}/updateAjax','MutabaahController@updateAjax');
Route::delete('/mutabaah/{id}/deleteAjax','MutabaahController@deleteAjax');


?>
