<?php
Route::get('admin/customers/change_status', 'CustomerController@active');
Route::resource('admin/customers', 'CustomerController')->names([
	'create' => 'new',
	'destroy' => 'remove',
]);

Route::get('admin/active/user','CustomerController@activeUsers');
Route::get('admin/in-active/user','CustomerController@inActiveUsers');
Route::get('admin/pending-admin/user','CustomerController@adminPendingUsers');

Route::get('admin/verify-customer', 'CustomerController@verifyCustomer')->name('verify-customer');
Route::post('admin/business-not-approved', 'CustomerController@notApproveBusiness')->name('business-not-approved');
  

Route::get('admin/in-active/user-detail/{id}','CustomerController@inActiveUserDeatil')->name('inactive-user-detail');
Route::get('admin/active/user-detail/{id}','CustomerController@activeUserDeatil')->name('inactive-user-detail');
Route::post('admin/user/remove','CustomerController@destroy')->name('delete-customer');
Route::get('admin/delete-inactivecustomer', 'CustomerController@deleteinActiveUser')->name('delete-inactivecustomer');
