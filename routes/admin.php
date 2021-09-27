<?php

/*
|--------------------------------------------------------------------------
| Broadcast Channels
|--------------------------------------------------------------------------
|
| Here you may register all of the event broadcasting channels that your
| application supports. The given channel authorization callbacks are
| used to check if an authenticated user can listen to the channel.
|
*/

Route::group(['namespace' => 'Admin'], function ($router) {
    
    Route::group(['as' => 'admin.'], function () {
	    Auth::routes(['register' => false, 'verify' => false]);

	    Route::get('/', function () {
		    return redirect(route('admin.dashboard'));
		});
	    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
	    Route::get('logout', 'Auth\LoginController@logout')->name('logout');
	    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

		Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
	    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');
		Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
	    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('password.update');
	});    

    Route::group(['middleware' => 'admin', 'as' => 'admin.'], function () {
        Route::get('dashboard', 'DashboardController@index')->name('dashboard');
        Route::get('profile/edit', 'AdminController@edit')->name('profile.edit');
        Route::post('profile/update', 'AdminController@update')->name('profile.update');

        Route::resource('users', 'UserController');
        Route::post('users', ['as' => 'users.index', 'uses' => 'UserController@index'])->name('users.index');
        Route::get('users-export', 'UserController@usersExport');

        Route::resource('partners', 'PartnerController', [
				    'except' => [ 'show' ]
				]);
        Route::resource('services', 'ServiceController');
        Route::resource('facilities', 'FacilityController');
        Route::resource('testimonials', 'TestimonialController');
        Route::resource('reviews', 'ReviewController');

        Route::get('reviews/approve/{id}', 'ReviewController@reviewApproval')->name('reviews.approve');
        Route::get('testimonials/approve/{id}', 'TestimonialController@testmonialApproval')->name('testimonials.approve');
         //partner services 
        Route::get('service-template', 'PartnerController@seviceTemplateByType')->name('sevice.template');
        
        Route::get('partners/services', 'PartnerController@partnerServicesList')->name('partners.services');
        Route::post('partners/services', 'PartnerController@partnerServicesList')->name('partners.services');
        Route::get('partners/services/view/{id}', 'PartnerController@viewService')->name('partners.services.view');
        Route::get('partners/services/approve/{id}', 'PartnerController@serviceApproval')->name('partners.services.approve');
        Route::get('partners/services/export', 'PartnerController@providersExport')->name('partners.services.export');

        // Incompleted Provider Details
        Route::get('partners/services/incomplete', 'PartnerController@incompleteProvider')->name('partners.incomplete');
        Route::get('partners/services/incomplete/edit/{user_id}', 'PartnerController@incompleteProviderEdit')->name('partners.incomplete.edit');
        Route::delete('partners/services/incomplete/destroy/{id}', 'PartnerController@incompleteProviderDestroy')->name('partners.incomplete.destroy');

        Route::patch('partners/services/{id}/update', 'PartnerController@partnerServicesUpdate')->name('partners.services.update');
        Route::get('partners/services/edit/{id}', 'PartnerController@partnerServicesEdit')->name('partners.services.edit');
        Route::delete('partners/services/destroy/{id}', 'PartnerController@partnerServicesDestory')->name('partners.services.destroy');
        Route::get('partners/services/create/{partner_id}', 'PartnerController@partnerServicesCreate')->name('partners.services.create');
        Route::post('partners/services/store', 'PartnerController@partnerServicesStore')->name('partners.services.store');
        
        //partner Homes 
        Route::get('partners/homes', 'PartnerController@partnerHomesList')->name('partners.homes');
        Route::patch('partners/homes/{id}/update', 'PartnerController@partnerHomesUpdate')->name('partners.homes.update');
        Route::get('partners/homes/edit/{id}', 'PartnerController@partnerHomesEdit')->name('partners.homes.edit');
        Route::post('partners/homes/destroy/{id}', 'PartnerController@partnerHomesDestory')->name('partners.homes.destroy');
        Route::get('partners/homes/create/{partner_id}', 'PartnerController@partnerHomesCreate')->name('partners.homes.create');
        Route::post('partners/homes/store', 'PartnerController@partnerHomesStore')->name('partners.homes.store');

        // Equipme Added
        Route::get('equipment-show', 'PartnerController@getByEquipment');
        Route::post('equipment-store', 'PartnerController@equipmentStore')->name('equipment.store');
        Route::post('equipment-update', 'PartnerController@equipmentUpdate')->name('equipment.update');
        Route::post('equipment-delete', 'PartnerController@equipmentDelete')->name('equipment.delete');

        // Photo Delete
        Route::get('provider/photo/delete/{id}', 'PartnerController@providerPhotoDelete')->name('provider.photo.delete');
        Route::get('equipment-photo-delete', 'PartnerController@equipmentPhotoDelete');
        Route::get('view/new-changes/{user_id}', 'PartnerController@viewNewChanges')->name('view.changes');
        Route::get('profile/updated/approve/{id}', 'PartnerController@profileUpdatedApprove')->name('profile.updated.approve');

    });

});
