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

// Authentication user
Route::get('login',   ['as' => 'login',  'uses' => 'Auth\LoginController@showLoginForm']);
Route::post('login',  ['as' => 'login',  'uses' => 'Auth\LoginController@login']);
Route::post('logout', ['as' => 'logout', 'uses' => 'Auth\LoginController@logout']);

Route::post('telegram/webhook', ['as' => 'telegram.webhook', 'uses' => 'TelegramController@handler']);

// 'namespace' => 'CRM'
Route::group(['middleware' => ['auth'], 'namespace' => 'CRM'], function () {
    
    Route::get('/', ['as' => 'dashboard', 'uses' => 'DashboardController@index']);

    Route::get('orders/create/{customer_id?}', ['as' => 'orders.create',        'uses' => 'OrderController@create']);
    Route::post('orders/add/status/{id}',      ['as' => 'order.add.status',     'uses' => 'OrderController@addStatus']);
    Route::post('orders/add/discount/{id}',    ['as' => 'order.add.discount',   'uses' => 'OrderController@addDiscount'])->where('id', '[0-9]+');
    Route::post('orders/add/service/{id}',      ['as' => 'order.add.service',    'uses' => 'OrderController@addService']);
    Route::put('orders/update/service/{id}',    ['as' => 'order.update.service',   'uses' => 'OrderController@updateService'])->where('id', '[0-9]+');
    Route::delete('orders/update/service/{id}', ['as' => 'order.destroy.service',   'uses' => 'OrderController@deleteService'])->where('id', '[0-9]+');
    Route::post('orders/add/repairpart/{id}',      ['as' => 'order.add.repairPart', 'uses' => 'OrderController@addRepairPart']);
    Route::put('orders/update/repairpart/{id}',    ['as' => 'order.update.repairPart',   'uses' => 'OrderController@updateRepairPart'])->where('id', '[0-9]+');
    Route::delete('orders/update/repairpart/{id}', ['as' => 'order.destroy.repairPart',   'uses' => 'OrderController@deleteRepairPart'])->where('id', '[0-9]+');
    
    Route::resource('orders', 'OrderController')->except(['create']);
    Route::resources([
        'customers'       => 'CustomerController',
        'manufacturers'   => 'ManufacturerController',
        'typedevices'     => 'TypeDeviceController',
        'defects'         => 'DefectController',
        'equipments'      => 'EquipmentController',
        'conditions'      => 'ConditionController',
        'typeservices'    => 'TypeServiceController',
        'typerepairparts' => 'TypeRepairPartController',
        'devicemodels'    => 'DeviceModelController',
        'users'           => 'UserController',
    ]);

    Route::post('users/password/{id}', ['as' => 'users.password.update','uses' => 'UserController@updatePassword']);

    Route::post('search/customer',     ['as' => 'search.customer',     'uses' => 'SearchController@searchCustomer']);
    Route::post('search/sn',           ['as' => 'search.sn',           'uses' => 'SearchController@searchSN']);
    Route::post('search/model',        ['as' => 'search.model',        'uses' => 'SearchController@searchModel']);
    Route::post('search/defect',       ['as' => 'search.defect',       'uses' => 'SearchController@searchDefect']);
    Route::post('search/condition',    ['as' => 'search.condition',    'uses' => 'SearchController@searchCondition']);
    Route::post('search/equipment',    ['as' => 'search.equipment',    'uses' => 'SearchController@searchEquipment']);
    Route::post('search/manufacturer', ['as' => 'search.manufacturer', 'uses' => 'SearchController@searchManufacturer']);
    Route::post('search/typedevice',   ['as' => 'search.typeDevice',   'uses' => 'SearchController@searchTypeDevice']);
    Route::post('search/service',      ['as' => 'search.service',      'uses' => 'SearchController@searchService']);
    Route::post('search/repairpart',   ['as' => 'search.repairPart',   'uses' => 'SearchController@searchRepairPart']);
    Route::post('search/status',       ['as' => 'search.status',       'uses' => 'SearchController@searchStatus']);
    Route::post('search/topsearch',    ['as' => 'search.top',          'uses' => 'SearchController@searchTop']);
    
    Route::post('info/customer',   ['as' => 'info.customer',   'uses' => 'GetInfoController@getCustomerInfo']);
    Route::post('info/sn',         ['as' => 'info.sn',         'uses' => 'GetInfoController@getSNInfo']);
    Route::post('info/device',     ['as' => 'info.device',     'uses' => 'GetInfoController@getDeviceInfo']);
    Route::post('info/model',      ['as' => 'info.model',      'uses' => 'GetInfoController@getModelInfo']);
    Route::post('info/typeservice',['as' => 'info.typeService','uses' => 'GetInfoController@getTypeServiceInfo']);
    Route::post('info/service',    ['as' => 'info.service',    'uses' => 'GetInfoController@getServiceInfo']);
    Route::post('info/repairpart', ['as' => 'info.repairPart', 'uses' => 'GetInfoController@getRepairPartInfo']);
    Route::post('info/typerepairpart', ['as' => 'info.typeRepairPart', 'uses' => 'GetInfoController@getTypeRepairPartInfo']);

    Route::get('settings/user',  ['as' => 'settings.user.show',   'uses' => 'SettingController@showUserSettings']);
    Route::put('settings/user',  ['as' => 'settings.user.update', 'uses' => 'SettingController@updateUserSettings']);
    Route::get('settings/{id?}', ['as' => 'settings.show',        'uses' => 'SettingController@show']);
    Route::put('settings/{id?}', ['as' => 'settings.update',      'uses' => 'SettingController@update']);
    
    Route::get('download/receipt/{id}', ['as' => 'download.receipt', 'uses' => 'ConvertToPDFController@downloadReceiptDevice'])->where('id', '[0-9]+');
    Route::get('download/act/{id}',     ['as' => 'download.act',     'uses' => 'ConvertToPDFController@downloadAct'])->where('id', '[0-9]+');
    Route::get('download/report-repair-part', ['as' => 'download.report-repair-part', 'uses' => 'ConvertToPDFController@downloadReportRepairPart']);
    Route::get('download/report-services', ['as' => 'download.report-repair-part', 'uses' => 'ConvertToPDFController@downloadReportServices']);

});

 
