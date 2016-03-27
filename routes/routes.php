<?php

Route::get('/sms-management/fake-sms', '\Klsandbox\SmsManager\SmsManagementController@getFakeSms');

Route::group(['middleware' => ['auth.admin']], function () {
    Route::get('/sms-management/view', '\Klsandbox\SmsManager\SmsManagementController@getView');
});

