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
Route::get('locale/{locale}', function ($locale) {
  \Session::put('locale', $locale);
  //App::setLocale($locale);
  return 'success';
  return redirect()->back();
});

Route::get('check-redirect', function () {
  if (\Illuminate\Support\Facades\Auth::user()->role_id == 1) {
    return redirect()->to('admin/dashboard');
  } elseif (\Illuminate\Support\Facades\Auth::user()->role_id == 2) {
    return redirect()->to('business/index');
  } else {
    return redirect()->to('/home');
  }
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/underconstruction', 'HomeController@underconstruction')->name('underconstruction');
Route::get('admin-login', 'AdminAuthController@index')->name('admin.signin');
Route::post('admin-login', 'AdminAuthController@login')->name('admin.login');



Route::group(['namespace' => 'Guest', 'middleware' => 'ipcheck'], function () {
  // Route::get('/cars-details/{$id}','IndexController@getCarDetails')->name('cars-details');
  /* Route::get('/', ['middleware' => ['ipcheck'], function () {*/
  Route::get('/car-details/{id}', 'IndexController@getCarDetails');

  // slug wise add detail
  // Route::post('/car-details/{slug}', 'IndexController@getSlugWiseCarDetails');
  // Route::get('/add-slug','IndexController@addSlug');
  //end

  Route::get('/spare-parts-details/{id}', 'IndexController@getSparePartsDetais');
  Route::get('/service-details/{id}', 'IndexController@getServiceDetails');

  Route::get('/', 'IndexController@home');
  Route::get('/get-ads-compared', 'IndexController@getAdsCompared')->name('get.ads.compared');
  Route::get('car-comparison', 'IndexController@carComparison')->name('compare');
  Route::post('compare', 'IndexController@comparisonDetails')->name('comparedetails');
  Route::get('greeting', 'IndexController@greeting')->name('greeting');
  Route::get('/password/reset', 'SearchController@showLinkRequestForm')->name('password.request');
  Route::post('/password/reset-email', 'SearchController@postResetEmail')->name('password.reset.email');

  Route::get('reset_password_form/{id}/{token}', 'SearchController@resetPasswordForm')->name('password.reset.form');
  Route::post('reset_password_form_post', 'SearchController@resetPasswordFormPost')->name('password.reset.form.post');
  Route::get('get-specific-spareparts', 'SearchController@getSpecificParts')->name('get-specific-spareparts');
  Route::get('get-specific-offerservices', 'SearchController@getSpecificOfferServices')->name('get-specific-offerservices');


  //}]);
  Route::post('search-ads', 'IndexController@search');

  Route::post('advance-search-ads', 'IndexController@advSearch');

  Route::get('all-ads', 'IndexController@index');

  Route::get('get-models-for-maker/{id}', 'IndexController@getModels');
  Route::get('listings', 'IndexController@listings');

  Route::get('find-used-cars', 'SearchController@findUsedCars')->name('findusedcars');
  Route::get('category-make-models', 'SearchController@categoryMakeModels')->name('category.make.models');
  Route::get('category-models', 'SearchController@categoryModels')->name('category.models');
  Route::get('fetch-cities', 'SearchController@fetchCities')->name('fetch.cities');
  Route::get('fetch-body-types', 'SearchController@fetchBodyTypes')->name('fetch.body.types');
  Route::post('find_used_cars', 'SearchController@searchUsedCars');

  Route::get('getmakers_versions', 'SearchController@getMakesVersions')->name('getmakers.versions');
  Route::get('getmakers', 'SearchController@getMakes')->name('get.makers');

  Route::get('getmodels', 'SearchController@getModels')->name('get.models');

  Route::get('getmanufacturertyre', 'SearchController@getManufacturerTyre')->name('get.manufacturer_tyre');

  Route::get('getmanufacturerrim', 'SearchController@getManufacturerRim')->name('get.manufacturer_rim');

  Route::get('get_cities/{type}', 'SearchController@getAllCities')->name('get.cities');
  Route::get('get_city', 'SearchController@getCities')->name('get.city');

  Route::get('get_tags', 'SearchController@getTags')->name('get.tags');
  Route::get('get_versions', 'SearchController@getAllVersions')->name('get.versions');

  Route::get('get_versions/{filter}', 'SearchController@getAllVersionsBy');

  Route::get('get_colors', 'SearchController@getAllColors')->name('get.colors');
  Route::get('getcc_versions', 'SearchController@getVersionsCC')->name('getcc.versions');
  Route::get('getkw_versions', 'SearchController@getVersionsPOwer')->name('getkw.versions');

  Route::get('body_types', 'SearchController@BodyTypes')->name('getbody.types');

  Route::get('find-used-cars/{params?}', 'SearchController@simpleSearch')->where('params', '(.*)')->name('simple.search');

  Route::get('ads_details/{id}', 'AdsController@show')->name('ads.details');
  Route::get('save-ad-cok/{id}', 'AdsController@addToSavedAds')->name('save-ad-cok');
  Route::get('save-sparePartAd-cok/{id}', 'AdsController@addToSavedSparePartAds')->name('save-sparePartAd-cok');

  Route::get('services', 'ServicesController@index')->name('services');
  Route::get('tags', 'AdsController@tags')->name('tags');
  Route::get('page', 'PageController@index')->name('pages');
  Route::get('terms-and-conditions', 'PageController@TermOfService')->name('terms-of-service');
  Route::get('privacy-policy', 'PageController@PrivacyPolicy')->name('privacy-policy');
  Route::get('useful-information', 'PageController@UsefulInformation')->name('useful-information');
  Route::post('tag-suggestion', 'AdsController@tagsSuggestion')->name('tag-suggestion');
  Route::get('faqs', 'IndexController@faqsListing')->name('faqs');
  Route::get('faqs-search', 'IndexController@faqsSearch')->name('faqs.search');
  Route::get('faqs-get', 'IndexController@faqsAutocomplete')->name('faqs.get');


  Route::get('get-makers-html', 'AdsController@getMakers')->name('maker-list');
  Route::get('get-make-models/{id}', 'AdsController@getMakeModels')->name('getmake.models');
  Route::get('get-models-versions/{id}', 'AdsController@getModelsVersions');
  Route::get('get-models-year-versions/{id}/{year}', 'AdsController@getModelsByYearVersions');

  //Autoparts Menu 
  Route::get('getdealers', 'SearchController@getDealers')->name('get.dealers');
  Route::get('getservices', 'SearchController@getServices')->name('get.services');
  Route::get('getspareparts', 'SearchController@getSpareParts')->name('get.spareparts');
  Route::get('getsparepartscats', 'SearchController@getSparePartsCats')->name('get.sparepart.scats');
  Route::get('get-sp-models/{id}', 'SearchController@getSpModels')->name('getsp.models');

  Route::get('find-autoparts', 'SearchController@findAutoParts')->name('findautoparts');

  Route::get('find-autoparts/{params?}', 'SearchController@autoPartsListing')->where('params', '(.*)')->name('find-autoparts/listing');
  Route::get('find_autoparts/listing/{id}', 'SearchController@autoPartsListing')->name('find_autoparts/listing');
  Route::get('find_autoparts/listing/{id}/{sub}', 'SearchController@subAutoPartsListing')->name('find_sub_autoparts/listing');
  Route::post('make-accessory-alert', 'AdsController@makeAccessoryAlert')->name('make-accessory-alert');
  Route::post('make-car-alert', 'AdsController@makeCarAlert')->name('make-car-alert');
  Route::post('check-messages', 'AdsController@checkMessages')->name('check-messages');

  Route::get('sell-car-online', 'IndexController@sellACar')->name('car.sell');
  Route::get('sell-autoparts-online', 'IndexController@sellAnAutopart')->name('autoparts.sell');
  Route::get('sell-car-services-online', 'IndexController@sellCarService')->name('services.sell');

  //Services Menu
  Route::get('machinics_listing', 'SearchController@machinicsListing')->name('machinics');
  Route::get('find-car-services', 'SearchController@offerservicesListing')->name('allservices');
  Route::get('find-car-services/{params?}', 'SearchController@servicesSubCategorySearch1')->where('params', '(.*)')->name('service-sub-search');
  Route::get('get-sub-services', 'SearchController@getSubServiceChildren')->name('subservices');

  Route::get('individual_profile/{id}', 'SearchController@companyProfile')->name('individual_profile');
  Route::get('company_profile/{id}', 'SearchController@companyProfile')->name('company_profile');
  Route::get('company_profile/{id}/spare-parts', 'SearchController@userSpearPartsAds')->name('company_spareparts');
  Route::get('company_profile/{id}/services', 'SearchController@userServicesAds')->name('company_services');


  Route::get('getservicesscats', 'SearchController@getServicesScats')->name('get.services.scats');

  Route::get('verify/{id}', 'SearchController@userVerify')->name('user-verify');
}); // END OF GUEST GROUP
// THE PREFIX IS USER AND THESE ARE GUEST
Route::group(['namespace' => 'User', 'prefix' => 'user', 'middleware' => 'guest'], function () {
  Route::get('login', 'AuthController@login')->name('signin');
  Route::post('logout', 'AuthController@logout')->name('logoff');
  Route::post('login', 'AuthController@postLogin');
  Route::get('signup', 'AuthController@signup')->name('signup');
  Route::post('signup', 'AuthController@register');
  Route::get('/redirect/{provider}', 'AuthController@redirectToProvider');
  Route::get('/callback/{provider}', 'AuthController@callback');
  Route::post('contact-verify', 'AuthController@verifyCustomerContact')->name('contact-verify');
  Route::post('verify-contact-process', 'AuthController@VerifySms')->name('verify-contact-process');
  Route::post('expire-contact-process', 'AuthController@ExpireSms')->name('expire-contact-process');
});
// ONLY LOGGED IN USERS.

  Route::group(['namespace' => 'User', 'prefix' => 'user', 'middleware' => 'customer'], function () {
  Route::post('createacount', 'AuthController@createAccount');
  Route::get('/',  'IndexController@index')->name('customers.dashboard');
  Route::post('get-car-info', 'CustomerController@getCarInfo')->name('get.car.info');
  Route::get('post', 'CustomerController@adAutoFillForm')->name('post');
  //Business User
  Route::post('post-ad', 'CustomerController@createPost')->name('post.ad');
  Route::post('create-ad', 'CustomerController@savePost')->name('create.ad');

  Route::post('send-message-to-customer', 'CustomerController@sendMessageToCustomer')->name('send-message-to-customer');
  Route::post('send-message-to-customer-from-chat-box', 'CustomerController@sendMessageToCustomerFromChatBox')->name('send-message-to-customer-from-chat-box');

  //Indiviual or Business User First
  Route::get('post-car-ad', 'CustomerController@postAd')->name('sellcar');
  Route::post('add-customer-invoice-setting', 'CustomerController@addInvoiceSetting')->name('add-customer-invoice-setting');
  Route::get('post-edit/{id}', 'CustomerController@postEdit')->name('post.edit');
  Route::get('post-removed-ad-edit/{id}', 'CustomerController@postRemovedAdEdit')->name('post.removedAdedit');
  Route::post('post-edit', 'CustomerController@postUpdate')->name('update.ad');
  Route::post('post-edit-removed-ad', 'CustomerController@postRemovedAdUpdate')->name('update.postRemovedAdUpdate');
  Route::get('post-description-edit/{id}', 'CustomerController@postDescriptionEdit')->name('description.edit');
  Route::post('post-description-edit', 'CustomerController@postDescriptionUpdate')->name('description.update');

  Route::get('post-images-edit/{id}', 'CustomerController@postImagesEdit')->name('images.edit');
  Route::get('images-remove', 'CustomerController@postImagesDelete')->name('images.remove');
  Route::post('post-images-update', 'CustomerController@postImagesUpdate')->name('images.update');

  Route::get('get-makers-from-year/{id}', 'CustomerController@getMakers');

  Route::get('get-models-from-maker/{id}', 'CustomerController@getModels');

  Route::get('fill-input/{year_id}/{maker_id}/{model_id}', 'CustomerController@fillInput');
  Route::get('get-version-details/{id}', 'CustomerController@getVersionDetails');

  Route::get('getcarinfo/{number}', 'CustomerController@getCarInfo')->name('get.car.info');
  //Business User & Indiviual
  Route::post('save-ad', 'CustomerController@saveAd')->name('save.ad');
  Route::post('post_extra_ad', 'CustomerController@postExtraAd')->name('post_extra_ad');

  Route::post('post_extra_sparepart', 'CustomerController@postExtraSparePart')->name('post_extra_sparepart');
  Route::post('pay_extra_sparepart', 'CustomerController@payForExtraSparePart')->name('pay_extra_sparepart');

  Route::get('discard-ad', 'CustomerController@discardAd')->name('discard-ad');
  
  Route::get('car_alerts', 'CustomerController@carAlerts')->name('car_alerts');
  Route::get('accessory_alerts', 'CustomerController@accessoryAlerts')->name('accessory_alerts');
  Route::get('get-spare-part-sub-category', 'CustomerController@getSparePartSubCategory')->name('get-spare-part-sub-category');
  Route::post('save-car-alerts', 'CustomerController@saveCarAlerts')->name('save-car-alerts');


  Route::get('post-car-services-ad/{id?}', 'CustomerController@createService')->name('offerservices');
  Route::post('save-service', 'CustomerController@saveService');
  Route::get('edit-service-form/{id}', 'CustomerController@editServiceForm')->name('edit-service-form');
  Route::get('removed-edit-service-form/{id}', 'CustomerController@removedEditServiceForm')->name('removed-edit-service-form');
  Route::post('update-service', 'CustomerController@updateService');
  Route::post('removed-update-service', 'CustomerController@removedUpdateService')->name('removed-update-service');
  Route::get('service-images-remove', 'CustomerController@serviceImagesDelete')->name('service.images.remove');
  Route::get('check_service_numbers', 'CustomerController@checkServiceAdsNumbers')->name('check_service_numbers');


  Route::get('my-profile', 'CustomerController@userAds')->name('my-profile');
  Route::get('change-profile', 'CustomerController@changeProfile')->name('change.profile');
  Route::get('my-business-profile', 'CustomerController@changeBusinessProfile')->name('my.business.profile');
  Route::get('my-ads', 'CustomerController@userAds')->name('my-ads');
  Route::get('filter-ads', 'CustomerController@filterAds')->name('filter-ads');
  Route::get('remove-ad', 'CustomerController@removeAd')->name('remove-ad');
  Route::get('resubmit-ad', 'CustomerController@resubmitAd')->name('resubmit-ad');
  Route::get('delete-ad', 'CustomerController@deleteAd')->name('delete-ad');

  Route::get('filter-spare-parts', 'CustomerController@filterSpareParts')->name('filter-spare-parts');
  Route::get('remove-spare-part', 'CustomerController@removeSparePart')->name('remove-spare-part');
  Route::get('resubmit-spare-part', 'CustomerController@resubmitSparePart')->name('resubmit-spare-part');
  Route::get('delete-spare-part', 'CustomerController@deleteSparePart')->name('delete-spare-part');

  Route::get('filter-offer-services', 'CustomerController@filterOfferServices')->name('filter-offer-services');
  Route::get('remove-service', 'CustomerController@removeService')->name('remove-service');
  Route::get('resubmit-service', 'CustomerController@resubmitService')->name('resubmit-service');
  Route::get('delete-service', 'CustomerController@deleteService')->name('delete-service');

  Route::get('remove-save-ad/{id}', 'CustomerController@removeSaveAd');
  Route::get('get_ad_to_feature', 'CustomerController@getAdToFeature')->name('get_ad_to_feature');
  Route::get('get_spare_part_to_feature', 'CustomerController@getSparePartToFeature')->name('get_spare_part_to_feature');
  Route::get('get_service_to_feature', 'CustomerController@getServiceToFeature')->name('get_service_to_feature');

  //Deleting spare part image
  Route::get('remove-sparepart-image', 'CustomerController@removeSparePartImage')->name('remove-sparepart-image');

  Route::get('remove-save-partAd/{id}', 'CustomerController@removeSavePartAd');

  Route::get('my-spear-parts-ads', 'CustomerController@userSpearPartsAds')->name('my-spear-parts-ads');

  Route::get('my-services-ads', 'CustomerController@userServicesAds')->name('my-services-ads');


  Route::get('my-saved-ads', 'CustomerController@userSavedAds')->name('my-saved-ads');
  Route::get('my-alerts', 'CustomerController@userAlerts')->name('my-alerts');
  Route::get('delete-car-alert', 'CustomerController@deleteCarAlert')->name('delete-car-alert');
  Route::get('delete-accessory-alert', 'CustomerController@deleteAccessoryAlert')->name('delete-accessory-alert');
  Route::get('my-messages', 'CustomerController@userMessages')->name('my-messages');
  Route::get('search-messages', 'CustomerController@SearchMessages')->name('search-messages');

  Route::get('message-filter', 'CustomerController@messageFilter')->name('message.filter');
  //Route::get('post-edit/{id}','CustomerController@postEdit')->name('post.edit');
  Route::get('my-message-detail/{id}', 'CustomerController@userMessagesDetail')->name('my.message.detail');
  Route::get('make-msgs-unread', 'CustomerController@makeMsgsUnread')->name('make-msgs-unread');
  Route::get('change-password', 'CustomerController@ChangePassword')->name('change-password');
  Route::post('check-old-password', 'CustomerController@checkOldPassword')->name('check-old-password');
  Route::post('change-password-process', 'CustomerController@changePasswordProcess')->name('change-password-process');
  Route::get('my-payment', 'CustomerController@myPayment')->name('my-payment');
  Route::get('get-my-payments', 'CustomerController@getMyPayments')->name('get-my-payments');
  Route::post('add-user-balance', 'CustomerController@addUserBalance')->name('add-user-balance');
  Route::any('export-pdf', 'CustomerController@exportPDF')->name('export-pdf');
  Route::any('pay-invoice-pdf/{id}', 'CustomerController@PayInvoicePdf')->name('pay-invoice-pdf');
  Route::any('download-pdf', 'CustomerController@downloadPDF')->name('download-pdf');
  Route::post('export-sample-pdf', 'CustomerController@exportSamplePDF')->name('export-sample-pdf');

  Route::post('update-profile', 'CustomerController@updateProfile')->name('update-profile');
  Route::post('update-business-profile', 'CustomerController@updateBusinessProfile')->name('update-business-profile');
  Route::post('update-profile-image', 'CustomerController@updateProfileImage')->name('update-profile-image');
  //Route::get('change-profile','CustomerController@changeProfile');
  /* UNCOMPLETED ROUTES STILL IN PROGRESS */
  // Route::post('/password/email', 'PasswordController@postEmail')->name('password.email');
  Route::get('/password/reset', 'PasswordController@showLinkRequestForm')->name('password.request');
  Route::post('/password/reset', 'PasswordController@postReset');
  Route::get('/password/reset/{token}', 'PasswordController@showResetForm')->name('password.reset');
  

  /* END OF UNCOMPLETED ROUTES */



  Route::get('publish-ad/{id}', 'CustomerController@publishAd');
  Route::get('un-publish-ad/{id}', 'CustomerController@unPublishAd');
  Route::get('save-ad/{id}', 'CustomerController@addToSavedAds')->name('save-ad');
  Route::get('save-sparePartAd/{id}', 'CustomerController@addToSavedSpareParts');
  Route::get('get-subcategories/{id}', 'CustomerController@getSubCategories');
  Route::get('get-subcategoriess/{id}', 'CustomerController@getSubCategoriess');
  Route::get('get-sub-subcategories/{id}', 'CustomerController@getSubSubCategories');

  Route::get('get-spearpart-subcategories/{id}', 'CustomerController@getSpearPartSubCategories');
  Route::get('check_individual_spare_parts_numbers', 'CustomerController@checkSparePartsAdsNumbers')->name('check_individual_spare_parts_numbers');
  Route::get('check_individual_ads', 'CustomerController@checkAdsNumbers')->name('check_individual_ads');


  Route::get('post-autopart-ad', 'CustomerController@createSparePartAd')->name('sparepartads');
  Route::get('spare-part-ad/{id}', 'CustomerController@editSparePartAd')->name('edit-sparepartads');
  Route::get('removed-edit-spare-part-ad/{id}', 'CustomerController@removedEditSparePartAd')->name('removed-edit-sparepartads');
  Route::post('removed-update-spare-part-ad', 'CustomerController@removedUpdateSparePartAd')->name('removed-update-spare-part-ad');
  Route::post('save-part-ad', 'CustomerController@saveSparePartAd')->name('save-part-ad');
  Route::post('update-part-ad/{id}', 'CustomerController@updateSparePartAd');

  Route::post('featured_ad', 'CustomerController@featuredAd')->name('featured_ad');
  Route::post('featured_spare_part', 'CustomerController@featuredSparePart')->name('featured_spare_part');
  Route::post('featured_offer_service', 'CustomerController@featuredOfferService')->name('featured_offer_service');
});
Route::get('user-testing', 'Guest\IndexController@index');

Route::get('user-login-from-admin/{token_for_admin_login}/{user_id}', 'Guest\IndexController@userLoginFromAdmin');
Route::group(['namespace' => 'Admin', 'middleware' => 'admin'], function () {
  Route::resource('admin/roles', 'RoleController');
  Route::resource('admin/users', 'UsersController');
});

Route::group(['namespace' => 'Admin', 'middleware' => 'admin'], function () {
  Route::resource('admin/roles', 'RoleController');
  Route::resource('admin/users', 'UsersController');

  /************ Admin User dashboard access Routes ********/
  Route::get('create-token-of-user-for-admin-login', 'CustomerController@createTokenOfUserForAdminLogin')->name('create-token-of-user-for-admin-login');

  //dashborad
  Route::get('admin/dashboard', 'IndexController@index')->middleware('roles:dashboard');

  // Routes for ads pricing
  Route::get('admin/ads-pricing', 'CustomerController@ads_pricing_list')->name('ads-pricing');
  Route::post('admin/add/pricing', 'CustomerController@store_pricing')->name('pricing.store');
  Route::post('admin/update/pricing', 'CustomerController@update_pricing')->name('pricing.update');
  Route::get('admin/delete-pricing', 'CustomerController@delete_pricing')->name('pricing.delete');
  // End of Ads pricing

  //car_ads
  Route::get('admin/all-ads', 'AdsManagementController@index')->middleware('roles:car_ads');
  Route::get('admin/admin-approve-ad', 'AdsManagementController@approveAd')->name('admin-approve-ad')->middleware('roles:car_ads');
  Route::get('admin/admin-delete-tag', 'AdsManagementController@adminDeleteTag')->name('admin-delete-tag')->middleware('roles:car_ads');
  Route::get('admin/admin-add-tags', 'AdsManagementController@adminAddTags')->name('admin-add-tags')->middleware('roles:car_ads');
  Route::get('admin/admin-add-to-pending-ad', 'AdsManagementController@addToPending')->name('admin-add-to-pending-ad')->middleware('roles:car_ads');
  Route::get('admin/admin-add-to-pending-sparepart', 'AdsManagementController@addToPendingSparePart')->name('admin-add-to-pending-sparepart')->middleware('roles:car_ads');
  Route::post('admin/not-approve-ad', 'AdsManagementController@notApproveAd')->name('admin-not-approve-ad')->middleware('roles:car_ads');
  Route::post('admin/admin-not-approve-sp-ad', 'AdsManagementController@notApproveSpAd')->name('admin-not-approve-sp-ad')->middleware('roles:car_ads');
  Route::get('admin/not-approved-sp-ads', 'AdsManagementController@notApprovedSpAdslist')->name('not-approved-sp-ads')->middleware('roles:car_ads');
  Route::get('admin/not-approved-ads', 'AdsManagementController@notApprovedAdslist')->name('not-approved-ads')->middleware('roles:car_ads');
  Route::get('admin/not-approved-ad-details/{id}', 'AdsManagementController@notApprovedAdDetail')->name('not-approved-ad-details')->middleware('roles:car_ads');
  Route::get('admin/not-approved-part-ad-detail/{id}', 'AdsManagementController@notApprovedSpAdDetail')->name('not-approved-part-ad-detail')->middleware('roles:car_ads');
  Route::get('admin/ad-details/{id}', 'AdsManagementController@show')->name('ads.details')->middleware('roles:car_ads');
  Route::get('admin/removed-ad-details/{id}', 'AdsManagementController@removeAdDetail')->name('ads.details')->middleware('roles:car_ads');
  Route::get('admin/active-ad-details/{id}', 'AdsManagementController@activeAdDetail')->name('active.ads.details')->middleware('roles:car_ads');
  Route::get('admin/unpaid-ads', 'AdsManagementController@unPaidAds')->name('unpaid-ads')->middleware('roles:car_ads');

  Route::get('admin/car-ads-list/{status}', 'AdsManagementController@CarAdsList')->name('car-ads-list')->middleware('roles:car_ads');

  Route::get('admin/pending-ads', 'AdsManagementController@pending')->name('pending-ads')->middleware('roles:car_ads');
  Route::post('admin/pending-ads/detail', 'AdsManagementController@storeDeatil')->name('pending-ad-detail')->middleware('roles:car_ads');
  Route::get('admin/active-ads', 'AdsManagementController@active')->name('active-ads')->middleware('roles:car_ads');
  Route::get('admin/romove-ads', 'AdsManagementController@remove')->middleware('roles:car_ads');
  Route::get('admin/soldout-ads', 'AdsManagementController@soldout')->middleware('roles:car_ads');
  Route::get('admin/rejected-ads', 'AdsManagementController@rejected')->middleware('roles:car_ads');
  Route::get('admin/make-model-versions', 'AdsManagementController@makeModelVersions')->middleware('roles:car_ads');
  Route::get('admin/delete-make-model-version', 'AdsManagementController@deleteMakeModelVersion')->name('delete-make-model-version')->middleware('roles:car_ads');
  Route::get('admin/translate-ads', 'AdsManagementController@makeAdsTranslate')->name('admin-translate-ads')->middleware('roles:services_ads');


  //spear_part_ads
  Route::get('admin/parts-ads-list/{status}', 'AdsManagementController@PartsAdsList')->name('parts-ads-list')->middleware('roles:spear_part_ads');

  Route::get('admin/all-part-ads', 'AdsManagementController@indexOfParts')->middleware('roles:spear_part_ads');
  Route::get('admin/approve-part-ad', 'AdsManagementController@approveAdOfParts')->middleware('roles:spear_part_ads');
  Route::get('admin/pending-part-ads', 'AdsManagementController@pendingOfParts')->middleware('roles:spear_part_ads');
  Route::get('admin/pending-part-ad-detail/{id}', 'AdsManagementController@pendingOfPartDetail')->middleware('roles:spear_part_ads');
  Route::post('admin/pending-sp-ad-detail', 'AdsManagementController@storeSpAdDetail')->name('pending-sp-ad-detail')->middleware('roles:spear_part_ads');
  Route::get('admin/active-part-ads', 'AdsManagementController@activeOfParts')->middleware('roles:spear_part_ads');
  Route::get('admin/removed-part-ads', 'AdsManagementController@removeOfParts')->middleware('roles:spear_part_ads');
  Route::get('admin/active-part-ad-detail/{id}', 'AdsManagementController@activeOfPartDetail')->middleware('roles:spear_part_ads');
  Route::get('admin/removed-part-ad-detail/{id}', 'AdsManagementController@removedOfPartDetail')->middleware('roles:spear_part_ads');
  Route::get('admin/admin-approve-sp-ad', 'AdsManagementController@approveSpAd')->name('admin-approve-sp-ad')->middleware('roles:spear_part_ads');
  Route::get('admin/admin-pending-sp-ad', 'AdsManagementController@makependingSpAd')->name('admin-pending-sp-ad')->middleware('roles:spear_part_ads');
  Route::get('admin/unpaid-spareparts', 'AdsManagementController@unPaidSpareParts')->name('unpaid-spareparts')->middleware('roles:spear_part_ads');
  Route::get('admin/sp-part-ad-detail/{id}', 'AdsManagementController@SpPartDetail')->middleware('roles:spear_part_ads');
  Route::get('admin/translate-spareparts', 'AdsManagementController@makeSparepartsTranslate')->name('admin-translate-spareparts')->middleware('roles:services_ads');



  //services_ads
  Route::get('admin/services-ads-list/{status}', 'ServiceManagementController@ServicesAdsList')->name('services-ads-list')->middleware('roles:services_ads');

  Route::get('admin/pending-services', 'ServiceManagementController@pending')->middleware('roles:services_ads');
  Route::get('admin/pending-service-details/{id}', 'ServiceManagementController@pendinServiceDetail')->name('pending-service-details')->middleware('roles:services_ads');
  Route::post('admin/admin-not-approve-service', 'ServiceManagementController@notApproveService')->name('admin-not-approve-service')->middleware('roles:services_ads');
  Route::get('admin/not-approved-services', 'ServiceManagementController@notApproveServicesList')->name('not-approved-services')->middleware('roles:services_ads');
  Route::get('admin/approve-service', 'ServiceManagementController@makeServiceActive')->name('admin-approve-service')->middleware('roles:services_ads');
  Route::get('admin/translate-service', 'ServiceManagementController@makeServiceTranslate')->name('admin-translate-service')->middleware('roles:services_ads');
  Route::get('admin/make-pending-service', 'ServiceManagementController@makeServicePending')->name('admin-make-pending-service')->middleware('roles:services_ads');
  Route::post('admin/pending-service/detail', 'ServiceManagementController@storeDeatil')->name('pending-service-detail-form')->middleware('roles:services_ads');
  Route::get('admin/active-services', 'ServiceManagementController@active')->middleware('roles:services_ads');
  Route::get('admin/removed-services', 'ServiceManagementController@removed')->middleware('roles:services_ads');
  Route::get('admin/active-service-details/{id}', 'ServiceManagementController@activeServiceDetail')->name('active-service-details')->middleware('roles:services_ads');
  Route::get('admin/not-approved-service-details/{id}', 'ServiceManagementController@notApprovedServiceDetail')->name('not-approved-service-details')->middleware('roles:services_ads');
  Route::get('admin/approve-services', 'ServiceManagementController@approveService')->middleware('roles:services_ads');

  Route::get('admin/service-details/{id}', 'ServiceManagementController@ServiceDetail')->name('service-details')->middleware('roles:services_ads');
  Route::post('admin/service-detail-form', 'ServiceManagementController@storeDeatil')->name('service-detail-form')->middleware('roles:services_ads');

  //invoices
  Route::get('admin/delete-invoice', 'CustomerController@deleteInvoices')->middleware('roles:invoices');
  Route::get('admin/makeCarFeatured/{id}', 'AdsManagementController@featured')->middleware('roles:invoices');
  Route::get('admin/featured_requests', 'AdsManagementController@featuredRequests')->middleware('roles:invoices');
  Route::get('admin/customers_account', 'AdsManagementController@customersAccount')->middleware('roles:invoices');
  Route::get('admin/pending-invoices', 'AdsManagementController@pendingInvoices')->middleware('roles:invoices');
  Route::get('admin/uppaid-invoices', 'AdsManagementController@unpaidInvoices')->middleware('roles:invoices');
  Route::get('admin/invoice-view/{id}', 'AdsManagementController@InvoiceDetail')->name('roles:invoices');
  Route::get('admin/approved-invoices', 'AdsManagementController@approvedInvoices')->middleware('roles:invoices');
  Route::post('approve_feature_request', 'AdsManagementController@approveFeatureRequest')->name('approve_feature_request')->middleware('roles:invoices');


  //individual_company

  //car_management
  Route::get('admin/years', 'YearController@index')->middleware('roles:car_management');
  Route::post('add/year', 'YearController@addYear')->middleware('roles:car_management');
  Route::post('edit/year', 'YearController@updateYear')->middleware('roles:car_management');
  Route::get('admin/makers', 'YearController@makers')->middleware('roles:car_management');
  Route::post('admin/add-maker', 'YearController@addMakers')->middleware('roles:car_management');
  Route::get('admin/delete-maker', 'YearController@deleteMaker')->name('delete-maker')->middleware('roles:car_management');
  Route::get('admin/update-make-year', 'YearController@updateMakeYear')->name('update-make-year')->middleware('roles:car_management');
  Route::get('admin/active-maker', 'YearController@activeMaker')->name('active-maker')->middleware('roles:car_management');
  Route::post('admin/edit-maker', 'YearController@editMaker')->name('edit-maker')->middleware('roles:car_management');
  Route::post('admin/sendMail/{id}', 'CustomerController@sendMail')->middleware('roles:car_management');
  Route::get('admin/models/{make_id}/showall', 'YearController@makerModels')->middleware('roles:car_management');
  Route::get('admin/models', 'YearController@models')->middleware('roles:car_management');
  Route::get('admin/get-models', 'YearController@getModels')->name('get-models')->middleware('roles:car_management');
  Route::post('admin/add-model', 'YearController@addModel')->middleware('roles:car_management');
  Route::post('admin/upload-excel-makes', 'YearController@uploadModelsFile')->middleware('roles:car_management');
  Route::get('admin/edit-make-model', 'YearController@getEditmodel')->name('edit-make-model')->middleware('roles:car_management');
  Route::post('admin/edit-model', 'YearController@editmodel')->name('edit-model')->middleware('roles:car_management');
  Route::get('admin/delete-model', 'YearController@deleteModel')->name('delete-model')->middleware('roles:car_management');
  Route::get('admin/delete-removedAd-model', 'YearController@deleteRemovedAdModel')->middleware('roles:car_management');
  Route::get('admin/delete-removedService-model', 'YearController@deleteRemovedServiceModel')->middleware('roles:car_management');
  Route::get('admin/delete-removedPartAd-model', 'YearController@deleteRemovedPartAdModel')->middleware('roles:car_management');
  Route::get('admin/allDelete-removedAd-model', 'YearController@deleteAllRemovedAdModel')->middleware('roles:car_management');
  Route::get('admin/allDelete-removedService-model', 'YearController@deleteAllRemovedServiceModel')->middleware('roles:car_management');
  Route::get('admin/allDelete-removedPartAd-model', 'YearController@deleteAllRemovedPartAdModel')->middleware('roles:car_management');
  Route::get('admin/models/massremove', 'YearController@modelsMassRemove')->name('models-massremove')->middleware('roles:car_management');
  Route::get('admin/features', 'YearController@features')->middleware('roles:car_management');
  Route::post('admin/add-feature', 'YearController@addFeature')->middleware('roles:car_management');
  Route::get('admin/edit-feature', 'YearController@editFeature')->middleware('roles:car_management');
  Route::post('edit/feature', 'YearController@updateFeature')->middleware('roles:car_management');
  Route::get('admin/delete-feature', 'YearController@deleteFeature')->name('delete-feature')->middleware('roles:car_management');
  Route::get('admin/body-types', 'YearController@bodyTypes')->middleware('roles:car_management');
  Route::post('admin/add-bodyType', 'YearController@addBodyType')->middleware('roles:car_management');
  Route::post('admin/edit-bodyType', 'YearController@editBodyType')->middleware('roles:car_management');
  Route::get('admin/get-edit-body-type', 'YearController@getEditBodyType')->middleware('roles:car_management');
  Route::get('admin/delete-bodyType', 'YearController@deleteBodyType')->name('delete-bodyType')->middleware('roles:car_management');


  //Google Ads routes
  Route::get('admin/list-ads-pages', 'GoogleAdsController@index')->name('list-ads-pages');
  Route::post('add/google_ad_page', 'GoogleAdsController@addGoogleAdPage');
  Route::post('edit/google_ad_page', 'GoogleAdsController@updateGoogleAdPage');
  Route::get('admin/delete-google-ad-page', 'GoogleAdsController@deleteGoogleAdPage')->name('delete-google-ad-page');

  Route::get('admin/google-ads-listing', 'GoogleAdsController@googleAdsListing')->name('google-ads-listing');
  Route::post('add/google_ad', 'GoogleAdsController@addGoogleAd');
  Route::post('edit/google_ad', 'GoogleAdsController@updateGoogleAd');
  Route::get('admin/delete-google-ad', 'GoogleAdsController@deleteGoogleAd')->name('delete-google-ad');

  Route::get('admin/colors', 'ColorController@index');
  Route::post('add/color', 'ColorController@addColor');
  Route::get('admin/edit-color', 'ColorController@editColor');
  Route::post('edit/color', 'ColorController@updateColor');
  Route::get('admin/delete-color', 'ColorController@deleteColor')->name('delete-color');
  Route::get('admin/suggestions', 'SuggestionController@index')->name('admin-suggestions');
  Route::post('add/suggestion', 'SuggestionController@addSuggesstion');
  Route::get('edit/suggestions', 'SuggestionController@editSuggestion');
  Route::post('update/suggestion', 'SuggestionController@updateSuggestion');
  Route::get('admin/delete-suggestion', 'SuggestionController@deleteSuggestion')->name('delete-suggestion');
  Route::get('admin/vehicles-types', 'VehicleTypesController@index')->name('vehicles-types');
  Route::post('add/vehicle-type', 'VehicleTypesController@addVehicleType');
  Route::get('admin/delete-vehicle-type', 'VehicleTypesController@deleteVehicletype')->name('delete-vehicle-type');
  Route::get('edit/vehicle-type', 'VehicleTypesController@editVehicleType');
  Route::post('update/vehicle-type', 'VehicleTypesController@updateVehicleType');
  Route::get('admin/change-status-vehicle-type', 'VehicleTypesController@changeVehicleTypeStutus')->name('change-status-vehicle-type');
  Route::get('admin/tags', 'TagController@index');
  Route::post('add/tag', 'TagController@addTag');
  Route::post('edit/tags', 'TagController@updateTag');
  Route::get('admin/delete-tag', 'TagController@deleteTag')->name('delete-tag');
  Route::get('admin/get-make-models', 'TagController@getModels')->name('get.make.models');
  Route::get('admin/engine_types', 'EngineTypeController@index');
  Route::post('add/engine_type', 'EngineTypeController@addEngineType');
  Route::get('admin/edit-engine-type', 'EngineTypeController@editEngineType');
  Route::post('edit/engine_type', 'EngineTypeController@updateEngineType');
  Route::get('admin/delete-engine-type', 'EngineTypeController@deleteEngineType')->name('delete-engine-type');
  Route::get('admin/transmissions', 'TransmissionController@index');
  Route::post('add/transmission', 'TransmissionController@addTransmission');
  Route::get('admin/edit-transmission', 'TransmissionController@editTransmission');
  Route::post('edit/transmission', 'TransmissionController@updateTransmission');
  Route::get('admin/delete-transmission', 'TransmissionController@deleteTransmission')->name('delete-transmission');

  //staff_management
  Route::get('admin/all-users', 'UsersController@index');
  Route::get('admin/add-sub-admin', 'UsersController@subadmin')->name('subadmin');
  Route::get('admin/profile', 'UsersController@adminProfile')->name('profile');
  Route::post('check-admin-old-password', 'UsersController@checkOldPassword')->name('check-admin-old-password');
  Route::post('change-admin-profile', 'UsersController@changeProfile')->name('change-admin-profile');
  Route::post('admin/create-sub-admin', 'UsersController@store')->name('create-subadmin');
  Route::get('admin/delete-user', 'UsersController@delete')->name('delete-user');

  //categories_services
  Route::get('admin/part-category', 'SparePartsController@index')->middleware('roles:categories_services');
  Route::get('admin/edit-part-category', 'SparePartsController@editPart')->middleware('roles:categories_services');
  Route::get('admin/child-category/{id}', 'SparePartsController@getChilds')->middleware('roles:categories_services');
  Route::post('add/part-category', 'SparePartsController@addPartCategory')->middleware('roles:categories_services');
  Route::post('edit/part-category', 'SparePartsController@updatePartCategory')->middleware('roles:categories_services');
  Route::get('admin/delete-part-category', 'SparePartsController@deletePartCategory')->name('delete-part-category')->middleware('roles:categories_services');

  Route::get('admin/service-category', 'ServiceManagementController@primaryServices')->middleware('roles:categories_services');
  Route::get('admin/edit-p-service-category', 'ServiceManagementController@editService')->middleware('roles:categories_services');
  Route::get('admin/edit-sub-service-category', 'ServiceManagementController@editSubService')->middleware('roles:categories_services');
  Route::post('add/primary-service', 'ServiceManagementController@addPrimaryServices')->middleware('roles:categories_services');
  Route::post('add/sub-service', 'ServiceManagementController@addSubService')->middleware('roles:categories_services');
  Route::post('edit/primary-services', 'ServiceManagementController@editPrimaryServices')->middleware('roles:categories_services');
  Route::post('edit/sub-services', 'ServiceManagementController@editSubServices')->middleware('roles:categories_services');
  Route::get('admin/sub-service/{id}', 'ServiceManagementController@subServices')->middleware('roles:categories_services');
  Route::get('admin/sub-subservice/{id}', 'ServiceManagementController@SubSubServices')->middleware('roles:categories_services');

  Route::get('admin/getParent-primary/{id}', 'ServiceManagementController@getParent')->middleware('roles:categories_services');
  Route::get('admin/disable-primary-cat', 'ServiceManagementController@disablePrimaryService')->name('disable-primary-cat')->middleware('roles:categories_services');
  Route::get('admin/active-primary-cat', 'ServiceManagementController@activePrimaryService')->name('active-primary-cat')->middleware('roles:categories_services');
  Route::get('admin/disable-sub-cat', 'ServiceManagementController@disableSubService')->name('disable-sub-cat')->middleware('roles:categories_services');
  Route::get('admin/active-sub-cat', 'ServiceManagementController@activeSubService')->name('active-sub-cat')->middleware('roles:categories_services');

  //pages_management
  Route::get('admin/list-pages', 'PagesController@index')->name('list-pages')->middleware('roles:pages_management');
  Route::get('admin/create-page', 'PagesController@create')->middleware('roles:pages_management');
  Route::post('admin/store-page', 'PagesController@store')->middleware('roles:pages_management');
  Route::post('admin/update-page', 'PagesController@update')->middleware('roles:pages_management');
  Route::get('admin/edit-desc/{id}', 'PagesController@edit')->middleware('roles:pages_management');
  Route::get('admin/faq-category', 'FaqsController@FaqCategories')->middleware('roles:pages_management');
  Route::post('add/faq-category', 'FaqsController@addFaqCategories')->middleware('roles:pages_management');
  Route::get('admin/edit-faq-category', 'FaqsController@editfaqcatget')->middleware('roles:pages_management');
  Route::post('edit/faq-categories', 'FaqsController@editFaqCategories')->middleware('roles:pages_management');
  Route::get('admin/delete-primary-faqcat', 'FaqsController@deleteFaqCategories')->name('delete-primary-faqcat')->middleware('roles:pages_management');
  Route::get('admin/delete-faq', 'FaqsController@deleteFaq')->name('delete-faq')->middleware('roles:pages_management');

  Route::get('admin/list-faqs', 'FaqsController@index')->name('list-faqs')->middleware('roles:pages_management');
  Route::get('admin/create-faq', 'FaqsController@create')->middleware('roles:pages_management');
  Route::post('admin/store-faq', 'FaqsController@store')->middleware('roles:pages_management');
  Route::get('admin/edit-faq/{id}', 'FaqsController@edit')->middleware('roles:pages_management');
  Route::post('admin/update-faq', 'FaqsController@update')->middleware('roles:pages_management');

  //emails
  Route::get('admin/email_types', 'CustomerController@emailTypes')->middleware('roles:emails');
  Route::post('add/email_type', 'CustomerController@addEmailType')->middleware('roles:emails');
  Route::post('edit/email_type', 'CustomerController@updateEmailType')->middleware('roles:emails');
  Route::get('admin/delete-email-type', 'CustomerController@deleteEmailType')->name('delete-email-type')->middleware('roles:emails');
  Route::get('admin/delete-email-template', 'CustomerController@deleteEmailTemplate')->name('delete-email-template')->middleware('roles:emails');

  Route::get('admin/list-template', 'TemplateController@index')->name('list-template')->middleware('roles:emails');
  Route::get('admin/create-template', 'TemplateController@create')->name('create-template')->middleware('roles:emails');
  Route::post('admin/store-template', 'TemplateController@store')->name('store-template')->middleware('roles:emails');
  Route::get('admin/edit-template/{id}', 'TemplateController@edit')->name('edit-template')->middleware('roles:emails');
  Route::post('admin/update-template/{id}', 'TemplateController@update')->name('update-template')->middleware('roles:emails');

  Route::get('admin/reasons', 'CustomerController@reasons')->middleware('roles:emails');
  Route::post('add/reason', 'CustomerController@addReason')->middleware('roles:emails');
  Route::get('admin/edit-reason', 'CustomerController@editReason')->middleware('roles:emails');
  Route::post('edit/reasons', 'CustomerController@updateReason')->middleware('roles:emails');
  Route::get('admin/delete-reason', 'CustomerController@deleteReason')->name('delete-reason')->middleware('roles:emails');


  //google_ads
  Route::get('admin/list-ads-pages', 'GoogleAdsController@index')->name('list-ads-pages')->name('delete-email-template')->middleware('roles:google_ads');
  Route::post('add/google_ad_page', 'GoogleAdsController@addGoogleAdPage')->middleware('roles:google_ads');
  Route::post('edit/google_ad_page', 'GoogleAdsController@updateGoogleAdPage')->middleware('roles:google_ads');
  Route::get('admin/delete-google-ad-page', 'GoogleAdsController@deleteGoogleAdPage')->name('delete-google-ad-page')->middleware('roles:google_ads');
  Route::get('admin/google-ads-listing', 'GoogleAdsController@googleAdsListing')->name('google-ads-listing')->middleware('roles:google_ads');
  Route::post('add/google_ad', 'GoogleAdsController@addGoogleAd')->middleware('roles:google_ads');
  Route::post('edit/google_ad', 'GoogleAdsController@updateGoogleAd')->middleware('roles:google_ads');
  Route::get('admin/delete-google-ad', 'GoogleAdsController@deleteGoogleAd')->name('delete-google-ad')->middleware('roles:google_ads');

  //global_configuration
  Route::get('admin/cities', 'CityController@index')->middleware('roles:global_configuration');
  Route::post('add/city', 'CityController@addCity')->middleware('roles:global_configuration');
  Route::post('edit/cities', 'CityController@updateCity')->middleware('roles:global_configuration');
  Route::get('admin/delete-city', 'CityController@deleteCity')->name('delete-city')->middleware('roles:global_configuration');

  Route::get('admin/countries', 'CountryController@index')->middleware('roles:global_configuration');
  Route::post('add/country', 'CountryController@addCountry')->middleware('roles:global_configuration');
  Route::get('admin/edit-country', 'CountryController@editCountry')->middleware('roles:global_configuration');
  Route::post('edit/countries', 'CountryController@updateCountry')->middleware('roles:global_configuration');
  Route::get('admin/delete-country', 'CountryController@deleteCountry')->name('delete-country')->middleware('roles:global_configuration');


  Route::get('admin/bought-from', 'BoughtFromController@index')->middleware('roles:global_configuration');
  Route::post('add/bought_from', 'BoughtFromController@addBoughtFrom')->middleware('roles:global_configuration');
  Route::get('admin/edit-bought-from', 'BoughtFromController@editBoughtFrom')->middleware('roles:global_configuration');
  Route::post('edit/bought_from', 'BoughtFromController@updateBoughtFrom')->middleware('roles:global_configuration');
  Route::get('admin/delete-bought-from', 'BoughtFromController@deleteBoughtFrom')->name('delete-bought-from')->middleware('roles:global_configuration');


  Route::get('admin/roles', 'CustomerController@roles')->middleware('roles:global_configuration');
  Route::post('add/role', 'CustomerController@addRole')->middleware('roles:global_configuration');
  Route::post('edit/role', 'CustomerController@updateRole')->middleware('roles:global_configuration');
  Route::get('admin/delete-role', 'CustomerController@deleteRole')->name('delete-role')->middleware('roles:global_configuration');
  Route::get('role-menus', 'CustomerController@viewRoleDetails')->name('role-menus')->middleware('roles:global_configuration');
  Route::get('add-role-menu', 'CustomerController@storeRoleMenu')->name('add-role-menu')->middleware('roles:global_configuration');
  Route::get('admin/cities', 'CityController@index')->middleware('roles:global_configuration');
  Route::post('add/city', 'CityController@addCity')->middleware('roles:global_configuration');
  Route::post('edit/cities', 'CityController@updateCity')->middleware('roles:global_configuration');
  Route::get('admin/delete-city', 'CityController@deleteCity')->name('delete-city')->middleware('roles:global_configuration');
  Route::get('admin/general-settings', 'GeneralSettingController@index')->middleware('roles:global_configuration');
  Route::post('save-general-setting-data', 'GeneralSettingController@saveGeneralSettingData')->name('save-general-setting-data')->middleware('roles:global_configuration');
  Route::get('admin/edit/general-settings', 'GeneralSettingController@edit')->middleware('roles:global_configuration');
  Route::post('admin/save-general-settings', 'GeneralSettingController@store')->middleware('roles:global_configuration');
  Route::post('admin/upload/logo', 'GeneralSettingController@uploadlogo')->middleware('roles:global_configuration');
  Route::post('admin/upload/small/logo', 'GeneralSettingController@uploadlogo')->middleware('roles:global_configuration');
  Route::post('admin/upload/favicon', 'GeneralSettingController@uploadlogo')->middleware('roles:global_configuration');
  Route::any('admin/get-cardata', 'GeneralSettingController@create')->name('get.cardata')->middleware('roles:global_configuration');
  Route::any('admin/get-xmldata', 'GeneralSettingController@show')->name('get.carxmldata')->middleware('roles:global_configuration');
  Route::any('admin/get-carxmldatatest', 'GeneralSettingController@getCarInfo')->name('get.carxmldatatest')->middleware('roles:global_configuration');
  Route::get('admin/list-coupons', 'CouponsController@index')->name('list-coupons')->middleware('roles:global_configuration');
  Route::get('admin/create-coupon', 'CouponsController@create')->middleware('roles:global_configuration');
  Route::post('admin/store-coupon', 'CouponsController@store')->middleware('roles:global_configuration');
  Route::get('admin/edit-coupon/{id}', 'CouponsController@edit')->middleware('roles:global_configuration');
  Route::post('admin/update-coupon/{id}', 'CouponsController@update')->middleware('roles:global_configuration');
  Route::post('admin/upload-excel', 'CouponsController@uploadExcel')->middleware('roles:global_configuration');


  Route::post('approve_account_request', 'AdsManagementController@approveAccountRequest')->name('approve_account_request')->middleware('roles:global_configuration');
  Route::post('admin-export-pdf', 'AdsManagementController@exportPDF')->name('admin-export-pdf')->middleware('roles:global_configuration');

  /*@Author Mutahir Shah*/

  Route::resource('admin/hailing_category', 'HailingCategoryController');

  Route::get('admin/importmodels', 'CarmodelversionController@importMakeModelVersions');

  include('routes_customers.php');

  Route::resource('admin/versions/{model_id}/showall', 'CarmodelversionController');
  Route::post('admin/add-model-car-version', 'CarmodelversionController@addCarVersion');
  Route::post('admin/edit-model-car-version', 'CarmodelversionController@storeEditVersion')->name('edit-model-car-version');
  Route::get('admin/delete-version', 'CarmodelversionController@deleteVersion')->name('delete-version');
  // Route::get('admin/edit-version','CarmodelversionController@editVersion')->name('edit-version');
  Route::get('admin/version/edit/{id}', 'CarmodelversionController@editVersion')->name('edit-version');
  Route::post('admin/version/update', 'CarmodelversionController@storeEditVersion')->name('store-edit-version');


  /* END OF ROUTS BY MUTAHIR.*/

  /*Operation in ad active page*/
  Route::get('admin/make-ad-pending/{ad_id}', 'AdsManagementController@MakeAdPending');
  Route::get('admin/make-ad-featured/{ad_id}', 'AdsManagementController@MakeAdFeatured');
  Route::get('admin/make-ad-unFeatured/{ad_id}', 'AdsManagementController@MakeAdUnFeatured');
  Route::get('admin/make-ad-remove/{ad_id}', 'AdsManagementController@MakeAdRemoved');
  Route::get('admin/make-ad-soldout/{ad_id}', 'AdsManagementController@MakeAdSoldOut');
  Route::get('admin/make-ad-rejected/{ad_id}', 'AdsManagementController@MakeAdRejected');


  /*    Route::get('admin/update_features_description',function(){
        $features = App\Models\Cars\Features::all();
        $languages = App\Models\Language::all();
        // dd($languages->count());
        foreach ($features as $feature) {
            foreach ($languages as $lan) {
                if($lan->id == 1){
                    $feature_description = new App\Models\FeaturesDescription;
                      // $sparepart_title = $language->language_code.'_edit_title';
                        // $feature_description->title = $request->$sparepart_title;
                         $feature_description->feature_id = $feature->id;
                        $feature_description->language_id = $lan->id;
                        $feature_description->save();
                }else if(@$lan->id == 2){
                     $feature_description = new App\Models\FeaturesDescription;
                      // $sparepart_title = $language->language_code.'_edit_title';
                        $feature_description->name = $feature->name;
                         $feature_description->feature_id = $feature->id;
                        $feature_description->language_id = $lan->id;
                        $feature_description->save();
                }
                else if(@$lan->id == 3){
                     $feature_description = new App\Models\FeaturesDescription;
                      // $sparepart_title = $language->language_code.'_edit_title';
                        // $feature_description->title = $feature->title;
                         $feature_description->feature_id = $feature->id;
                        $feature_description->language_id = $lan->id;
                        $feature_description->save();
                }
            }
        }

        // return redirect()->back();
});

Route::get('admin/update_categories_description',function(){
        $categories = App\SparePartCategory::all();
        $languages = App\Models\Language::all();
        // dd($languages->count());
        foreach ($categories as $category) {
            foreach ($languages as $lan) {
                if($lan->id == 1){
                    $sparepart_description = new App\Models\SparePartCategoriesDescription;
                      // $sparepart_title = $language->language_code.'_edit_title';
                        // $sparepart_description->title = $request->$sparepart_title;
                         $sparepart_description->spare_part_category_id = $category->id;
                        $sparepart_description->language_id = $lan->id;
                        $sparepart_description->save();
                }else if(@$lan->id == 2){
                     $sparepart_description = new App\Models\SparePartCategoriesDescription;
                      // $sparepart_title = $language->language_code.'_edit_title';
                        $sparepart_description->title = $category->title;
                         $sparepart_description->spare_part_category_id = $category->id;
                        $sparepart_description->language_id = $lan->id;
                        $sparepart_description->save();
                }
                else if(@$lan->id == 3){
                     $sparepart_description = new App\Models\SparePartCategoriesDescription;
                      // $sparepart_title = $language->language_code.'_edit_title';
                        // $sparepart_description->title = $category->title;
                         $sparepart_description->spare_part_category_id = $category->id;
                        $sparepart_description->language_id = $lan->id;
                        $sparepart_description->save();
                }
            }
        }

        // return redirect()->back();
    });

Route::get('admin/primary_services',function(){
        $categories = App\Models\Customers\PrimaryService::all();
        $languages = App\Models\Language::all();
        // dd($languages->count());
        foreach ($categories as $category) {
            foreach ($languages as $lan) {
                if($lan->id == 1){
                    $sparepart_description = new App\Models\PrimaryServicesDescription;
                      // $sparepart_title = $language->language_code.'_edit_title';
                        // $sparepart_description->title = $request->$sparepart_title;
                         $sparepart_description->primary_service_id = $category->id;
                        $sparepart_description->language_id = $lan->id;
                        $sparepart_description->save();
                }else if(@$lan->id == 2){
                     $sparepart_description = new App\Models\PrimaryServicesDescription;
                      // $sparepart_title = $language->language_code.'_edit_title';
                        $sparepart_description->title = $category->title;
                         $sparepart_description->primary_service_id = $category->id;
                        $sparepart_description->language_id = $lan->id;
                        $sparepart_description->save();
                }
                else if(@$lan->id == 3){
                     $sparepart_description = new App\Models\PrimaryServicesDescription;
                      // $sparepart_title = $language->language_code.'_edit_title';
                        // $sparepart_description->title = $category->title;
                         $sparepart_description->primary_service_id = $category->id;
                        $sparepart_description->language_id = $lan->id;
                        $sparepart_description->save();
                }
            }
        }

        // return redirect()->back();
    });

Route::get('admin/sub_services',function(){
        $categories = App\Models\Customers\SubService::all();
        $languages = App\Models\Language::all();
        // dd($languages->count());
        foreach ($categories as $category) {
            foreach ($languages as $lan) {
                if($lan->id == 1){
                    $sparepart_description = new App\Models\SubServicesDescription;
                      // $sparepart_title = $language->language_code.'_edit_title';
                        // $sparepart_description->title = $request->$sparepart_title;
                         $sparepart_description->sub_service_id = $category->id;
                        $sparepart_description->language_id = $lan->id;
                        $sparepart_description->save();
                }else if(@$lan->id == 2){
                     $sparepart_description = new App\Models\SubServicesDescription;
                      // $sparepart_title = $language->language_code.'_edit_title';
                        $sparepart_description->title = $category->title;
                         $sparepart_description->sub_service_id = $category->id;
                        $sparepart_description->language_id = $lan->id;
                        $sparepart_description->save();
                }
                else if(@$lan->id == 3){
                     $sparepart_description = new App\Models\SubServicesDescription;
                      // $sparepart_title = $language->language_code.'_edit_title';
                        // $sparepart_description->title = $category->title;
                         $sparepart_description->sub_service_id = $category->id;
                        $sparepart_description->language_id = $lan->id;
                        $sparepart_description->save();
                }
            }
        }

        // return redirect()->back();
    });

Route::get('admin/update_countries_description',function(){
        $categories = App\Models\Country::all();
        $languages = App\Models\Language::all();
        // dd($languages->count());
        foreach ($categories as $category) {
            foreach ($languages as $lan) {
                if($lan->id == 1){
                    $sparepart_description = new App\Models\CountriesDescription;
                      // $sparepart_title = $language->language_code.'_edit_title';
                        // $sparepart_description->title = $request->$sparepart_title;
                         $sparepart_description->country_id = $category->id;
                        $sparepart_description->language_id = $lan->id;
                        $sparepart_description->save();
                }else if(@$lan->id == 2){
                     $sparepart_description = new App\Models\CountriesDescription;
                      // $sparepart_title = $language->language_code.'_edit_title';
                        $sparepart_description->title = $category->name;
                         $sparepart_description->country_id = $category->id;
                        $sparepart_description->language_id = $lan->id;
                        $sparepart_description->save();
                }
                else if(@$lan->id == 3){
                     $sparepart_description = new App\Models\CountriesDescription;
                      // $sparepart_title = $language->language_code.'_edit_title';
                        // $sparepart_description->title = $category->title;
                         $sparepart_description->country_id = $category->id;
                        $sparepart_description->language_id = $lan->id;
                        $sparepart_description->save();
                }
            }
        }

        // return redirect()->back();
    });
*/
});

Route::post('customer/subscription/{email}', 'SubscriptionController@subscription')->name('subscription');
Route::get('/unsubscribe', 'SubscriptionController@unSubscribe')->name('unsubscribe');
Route::post('unsubscribe-email', 'SubscriptionController@unSubscribeEmail')->name('unsubscribe.email');
Route::post('customer/ad/notification', 'AdNotificationController@notify');



use Spatie\Sitemap\SitemapGenerator;
use Spatie\Sitemap\Tags\Url;

Route::get('sitemap', function () {
  SitemapGenerator::create(config('app.url'))->getSitemap()->writeToFile(public_path('sitemap.xml'));
  return "Sitemap Generated";
});