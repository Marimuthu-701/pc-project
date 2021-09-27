<?php

use Illuminate\Support\Facades\Route;

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

/*Route::get('/', function () {
    return view('welcome');
});*/

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

// Pages links route
Route::get('about-us', 'PageController@aboutUs')->name('about.us');
Route::get('services', 'PageController@services')->name('services');
Route::get('blog', 'PageController@blog')->name('blog');
Route::get('faq', 'PageController@faq')->name('faq');
Route::get('testimonial', 'PageController@testimonial')->name('testimonial');
Route::get('contact', 'PageController@contact')->name('contact');
Route::get('terms-conditions', 'PageController@termAndCondition')->name('terms.conditions');
Route::get('privacy-policy', 'PageController@privacyAndPolicy')->name('privacy.policy');
Route::get('testimonials/add', 'PageController@testimonialCreate')->name('testimonials.add');
Route::post('testimonials/add', 'PageController@testimonialCreate')->name('testimonials.add');

// Home and service detail page
Route::get('{type}/{slug}', 'AccountController@getByHomeService')->name('type.slug')->where('type', 'home|service');
Route::resource('review-rating', 'ReviewRatingController')->except(['index']);
Route::get('{type}/{id}/reviews/add', 'ReviewRatingController@index')->name('type.id.reviews.add')->where('type', 'home|service');

//services individual page
Route::get('services/ambulance', 'PageController@ambulanceService')->name('services.ambulance');
Route::get('services/nurse', 'PageController@nursingService')->name('services.nurse');
Route::get('services/physiotherapy', 'PageController@physiotherapyService')->name('services.physiotherapy');
Route::get('services/attendant', 'PageController@trainedAttendantService')->name('services.attendant');
Route::get('services/lab', 'PageController@labTestService')->name('services.lab');
Route::get('services/medical', 'PageController@medicalService')->name('services.medical');
Route::get('services/pharmacy', 'PageController@pharmacyService')->name('services.pharmacy');
Route::get('services/critical-care', 'PageController@criticalCareService')->name('services.critical-care');
Route::get('services/doctor-consultant', 'PageController@doctorConsultantService')->name('services.consultant');
// Contact form send email
Route::post('contact-form-email', 'ContactController@contactEmail')->name('contact.email');

//Serach controller routes
// Route::get('import-cities', 'HomeController@importIndianCities');
//Route::post('inner-search' ,'SearchController@innerSearch')->name('inner.search');
Route::get('provider/approval/{token}', 'HomeController@providerApproval')->name('provider.approval');
Route::get('reviews/approve/{token}', 'HomeController@approveReview')->name('reviews.approve');
Route::get('testimonial/approve/{token}', 'HomeController@testimonialApprove')->name('testimonial.approve');
Route::get('profile/updated/approve/{token}', 'HomeController@profileUpdatedApprove')->name('profile.updated.approve');

Route::get('search', 'SearchController@search')->name('search');
Route::post('get-locations', 'SearchController@getLocationsByState');
Route::post('service-category', 'SearchController@servicesAndCount');

// Mobile Number verification routes
Route::post('mobile-number/verification', 'PartnerController@mobileNumberVerification')->name('mobile.number.verification');
Route::get('mobile-number/verification', 'PartnerController@mobileNumberVerification')->name('mobile.number.verification');
Route::get('phone-verify', 'PartnerController@phoneVerify')->name('phone.verify');

// IMAGE RESIZE ROUTES
Route::group(['prefix' => 'storage'], function () {
	Route::get('services/banners/{filename}', ['uses' => 'PageController@viewImage', 'image_folder_path' => 'services/banners']);
	Route::get('services/banners/{size}/{filename}', ['uses' => 'PageController@viewImage', 'image_folder_path' => 'services/banners']);

	Route::get('services/icons/{filename}', ['uses' => 'PageController@viewImage', 'image_folder_path' => 'services/icons']);
	Route::get('services/icons/{size}/{filename}', ['uses' => 'PageController@viewImage', 'image_folder_path' => 'services/icons']);

	Route::get('id_proof/{filename}', ['uses' => 'PageController@viewImage', 'image_folder_path' => 'id_proof']);
	Route::get('id_proof/{size}/{filename}', ['uses' => 'PageController@viewImage', 'image_folder_path' => 'id_proof']);

	Route::get('services/{filename}', ['uses' => 'PageController@viewImage', 'image_folder_path' => 'services']);
	Route::get('services/{size}/{filename}', ['uses' => 'PageController@viewImage', 'image_folder_path' => 'services']);

	Route::get('avatar/{filename}', ['uses' => 'PageController@viewImage', 'image_folder_path' => 'avatar']);
	Route::get('avatar/{size}/{filename}', ['uses' => 'PageController@viewImage', 'image_folder_path' => 'avatar']);
});

// Unauthenticated routes
Route::group(['middleware' => ['guest']], function () {
	
	// User Login Routes
	Route::get('login', 'HomeController@index')->name('login');
	Route::post('login', 'Auth\LoginController@login');
	
	// User Registration Routes
	Route::get('register', 'HomeController@index')->name('register');
	Route::post('register', 'Auth\RegisterController@register');
	
	// Password Reset Routes
	Route::get('password/reset', 'HomeController@index')->name('password.request');
	Route::post('password/email', 'Auth\ForgotPasswordController@forgot')->name('password.email');
	Route::get('password/reset/{token}', 'HomeController@index')->name('password.reset');
	Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
	Route::post('password/verify-otp', 'Auth\ResetPasswordController@verifyOtp')->name('verify.otp');

	// Partner Registration Routes
	Route::get('provider/register', 'Auth\RegisterController@providerRegister')->name('provider.register');
	Route::post('provider/register', 'Auth\RegisterController@providerRegister')->name('provider.register');
	Route::post('otp-verification', 'Auth\RegisterController@otpVerification')->name('otp.verification');



	// Social Login routes
	Route::get('auth/google', 'Auth\SocialLoginController@redirectToGoogle');
	Route::get('account/google', 'Auth\SocialLoginController@googleAccountCallback');

	Route::get('auth/facebook', 'Auth\SocialLoginController@redirectToFacebook');
	Route::get('account/facebook', 'Auth\SocialLoginController@facebookAccountCallback');
});

// Authenticated routes
Route::group(['middleware' => ['auth']], function () {

    // Route::post('logout', 'Auth\LoginController@logout')->name('logout');
	Route::get('partner/register/{type}', 'PartnerController@partnerRegisterType')->name('partner.register.type');
	Route::post('partner/register/{type}', 'PartnerController@partnerRegisterType')->name('partner.register.type');

	// Profile routes
	Route::get('profile/edit', 'AccountController@profile')->name('profile.edit');
	Route::post('profile/update', 'AccountController@updateProfile')->name('profile.update');

	// service update routes
	Route::post('profile/service/update', 'AccountController@serviceUpdate')->name('profile.service.update');
	Route::post('profile/home/update', 'AccountController@homeUpdate')->name('profile.home.update');
	Route::post('mobile-number-change', 'AccountController@mobileNoChange')->name('mobile.number.change');
	Route::post('change-phone-otp-verify', 'AccountController@chagePhoneOtpVerify')->name('change.phone.otp.verify');

	Route::get('serive-provider-form', 'PartnerController@seviceProviderForm');
	Route::get('provider/select-service', 'PartnerController@serviceProvider')->name('service.provider');
	
	//User OTP verification
	Route::post('user-otp-verify', 'PartnerController@userOtpVerification')->name('user.opt.verify');
	Route::post('service/register', 'PartnerController@serviceRegister')->name('service.register');
	//Email Verification
	Route::get('email-verify', 'PartnerController@emailVerification')->name('email.verify');
	Route::post('email-verify', 'PartnerController@emailVerification')->name('email.verify');
	// Whish list routes
	Route::resource('wishlist', 'WishlistController');

	// Remove Equipment
	Route::get('equipment-list', 'AccountController@equipmentList');
	Route::get('equipment-show', 'AccountController@getByEquipment');
	Route::post('equipment-store', 'AccountController@equipmentStore')->name('equipment.store');
	Route::post('equipment-update', 'AccountController@equipmentUpdate')->name('equipment.update');
	Route::post('equipment-delete', 'AccountController@equipmentDelete')->name('equipment.delete');
	Route::get('equipment-photo-delete', 'AccountController@equipmentPhotoDelete');

	// Account Deleted
	Route::post('account-delete-email', 'AccountController@accountDeleteEmail');
	Route::get('account-delete-otp-verify', 'AccountController@accountDeleteOtpVerify')->name('account.delete.otp.verify');
	Route::post('account-delete-otp-verify', 'AccountController@accountDeleteOtpVerify')->name('account.delete.otp.verify');
	Route::post('account-delete', 'AccountController@accountDelete')->name('account.delete');

	//Provider Photo Delete
	Route::post('provider-photo-delete', 'AccountController@providerPhotoDelete');

});
