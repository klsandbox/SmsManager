<?php

Route::get('/sms-management/fake-sms', '\Klsandbox\SmsManager\SmsManagementController@getFakeSms');

Route::group(['middleware' => ['role:admin']], function () {
    Route::get('/sms-management/view', '\Klsandbox\SmsManager\SmsManagementController@getView');
    Route::post('/sms-management/delete-all', '\Klsandbox\SmsManager\SmsManagementController@deleteAll');
});

