<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::group(['middleware'=>['auth']], function(){
    Route::get('/', 'HomeController@index')->name('home');
    Route::get('/notificaciones','Notification\NotificationController@index')->name('notifications');
    Route::get('/manuales','Notification\NotificationController@manuales')->name('manuales');

    Route::group(['middleware' => ['root']], function () {
        Route::get('/traza','Trace\TraceController@index')->name('traces');
    });
    //grupo de rutas de vacaciones
    Route::group(['prefix'=>'holidays'], function(){
        Route::get('/menu','Holiday\HolidayController@menu')->name('holidays.menu');
        Route::get('/formulario_vacaciones','Holiday\HolidayController@form_request')->name('holidays.form_request');
        Route::post('/calcular','Holiday\HolidayController@calculate')->name('holidays.calculate');
        Route::post('/solicitar','Holiday\HolidayController@store')->name('holidays.store');
        Route::get('/statusVacaciones','Holiday\HolidayController@status')->name('holidays.status');
        Route::get('/mi_historial','Holiday\HolidayController@index')->name('holidays.record');
        Route::get('/fechas_feriados','FreeDay\FreeDayController@index')->name('holidays.feriados');
        Route::get('/contancia/{id}','Holiday\HolidayController@pdf')->name('holidays.cpdf');
        //acceso solo a los directores, supervisores y superadmin
        Route::group(['middleware'=>['especial']], function(){
            Route::get('/solicitudes_vacaciones','Holiday\HolidayController@getRequestHolidays')->name('holidays.getRequest');
            Route::put('/action/{id}','Holiday\HolidayController@update')->name('holidays.action');
            Route::get('/personal','User\UserController@getHolidayPersonal')->name('holidays.personal');
        });
        //acceso solo a los directores y superadmin
        Route::group(['middleware'=>['directors']], function(){
            Route::get('/estadisticas','Stadistics\StadisticsController@getStadistics')->name('holidays.stadistics');
            Route::get('/estadisticas-oficina','Stadistics\StadisticsController@getStadisticsByOffice')->name('holidays.stadisticsByOffice');
        });
        //acceso solo a los analistas de vacaciones
        Route::group(['middleware'=>['analist']], function(){
            Route::get('/revision','Holiday\HolidayController@revision')->name('holidays.revision');
            Route::get('/estado_usuario/{id}','User\UserController@edit')->name('holidays.editUser');
            Route::get('/historiales','Holiday\HolidayController@records')->name('holidays.checkRecord');
            Route::post('/crear_fecha','FreeDay\FreeDayController@store')->name('holidays.createFreeDay');
            Route::get('/visualizar_fecha/{id}','FreeDay\FreeDayController@edit')->name('holidays.editFreeDay');
            Route::put('/actualizar/{id}','FreeDay\FreeDayController@update')->name('holidays.updateFreeDay');
            Route::get('/eliminar_fecha/{id}','FreeDay\FreeDayController@destroy')->name('holidays.deleteFreeDay');
            Route::get('/confirmar_reintegro','Holiday\HolidayController@checkRefund')->name('holidays.checkRefund');
            Route::get('/confirmar_reintegro/{id}','Holiday\HolidayController@edit')->name('holidays.editHoliday');
            Route::put('/actualizar/{id}','Holiday\HolidayController@refund')->name('holidays.refundHoliday');
            Route::get('/administrar_personal','Holiday\HolidayController@manageStaff')->name('holidays.manageStaff');
            Route::get('/administrar_personal/{cedula?}','User\UserController@search')->name('holidays.search');
            Route::post('/crear_periodo','Period\PeriodController@store')->name('holidays.periodStore');
            Route::get('/crear_vacacion/{user_id?}','Holiday\HolidayController@createHoliday')->name('holidays.createHoliday');
        });

    });

    //Grupo de rutas para permisos
    Route::group(['prefix' => 'permits'], function () {
        Route::get('/menu','Permit\PermitController@menu')->name('permits.menu');
        Route::get('/menu','Permit\PermitController@menu')->name('permits.menu');
        Route::get('/formulario_permiso','Permit\PermitController@form_request')->name('permits.form_request');
        Route::post('/calcular','Permit\PermitController@calculate')->name('permits.calculate');
        Route::post('/solicitar','Permit\PermitController@store')->name('permits.store');
        Route::get('/estatus-permiso','Permit\PermitController@status')->name('permits.status');
        Route::get('/mi_historial','Permit\PermitController@index')->name('permits.record');
        Route::get('/contancia/{id}','Permit\PermitController@pdf')->name('permits.cpdf');
        //acceso solo a los directores, supervisores y superadmin
        Route::group(['middleware'=>['especial']], function(){
            Route::get('/solicitudes_permiso','Permit\PermitController@getRequestpermits')->name('permits.getRequest');
            Route::put('/action/{id}','Permit\PermitController@update')->name('permits.action');
            Route::get('/personal','User\UserController@getpermitPersonal')->name('permits.personal');
        });
        //acceso solo a los directores y superadmin
        Route::group(['middleware'=>['directors']], function(){
            Route::get('/estadisticas','Stadistics\StadisticsController@getStadistics')->name('permits.stadistics');
            Route::get('/estadisticas-oficina','Stadistics\StadisticsController@getStadisticsByOffice')->name('permits.stadisticsByOffice');
        });
        //acceso solo a los analistas de vacaciones
        Route::group(['middleware'=>['analist']], function(){
            Route::get('/revision','Permit\PermitController@revision')->name('permits.revision');
            Route::get('/estado_usuario/{id}','User\UserController@edit')->name('permits.editUser');
            Route::get('/historiales','Permit\PermitController@records')->name('permits.checkRecord');
        });
    });
});

