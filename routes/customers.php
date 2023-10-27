<?php
	Route::group(['namespace' => 'Customers','prefix' => 'customers'], function () {
	Route::get('login', 'AuthController@login')->name('signin');
	Route::post('logout', 'AuthController@logout')->name('logoff');
	Route::post('login', 'AuthController@postLogin');
	Route::get('signup', 'AuthController@signup')->name('signup');
	Route::post('signup', 'AuthController@register');
	Route::post('createacount', 'AuthController@createAccount');
	Route::post('frontlogin', 'AuthController@frontlogin');

	Route::get('edit-company', 'AuthController@edit')->name('company.edit');
	Route::get('edit-profile', 'AuthController@editProfile')->name('profile.edit');

	Route::post('/password/email','PasswordController@postEmail')->name('password.email');
	Route::get('/password/reset','PasswordController@showLinkRequestForm')->name('password.request');
	Route::post('/password/reset','PasswordController@postReset');
	Route::get('/password/reset/{token}','PasswordController@showResetForm')->name('password.reset');

	Route::get('/billing-info','ProfileController@getBillingInfo')->name('customers.billing');
	Route::post('/billing-info','ProfileController@postBillingInfo');

	Route::get('/billing-info/update-card','ProfileController@getUpdateCard')->name('customers.cupdate');

	Route::get('/update-billing','ProfileController@getBillingUpdate')->name('customers.updatebilling');

	Route::post('/update-billing','ProfileController@postBillingUpdate');

	Route::post('/billing-info/update-card','ProfileController@postUpdateCard')->name('billing.postcupdate');

	Route::post('/billing-info/update-expiry','ProfileController@postUpdateExpiry')->name('customers.updateexpiry');

	Route::get('/shipping-info','ProfileController@getShippingInfo')->name('customers.shipping');
	Route::post('/shipping-info','ProfileController@postShippingInfo');

	Route::get('/get-states','ProfileController@getStates')->name('customers.state');

	Route::post('/password/frontemail','PasswordController@frontPostEmail');
	Route::get('/',  'IndexController@index')->name('customers.dashboard');
	});



