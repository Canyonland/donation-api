<?php
//'auth:api',
Route::middleware('throttle:600,1')
    ->prefix('/api/v1')
    ->group(function () {
        // TODO some routes could be excluded, such as "create" if default create form is not needed.

        Route::get('activities/search', 'OCEF\DonationAPI\Controllers\ActivityController@search');
        Route::resource('activities', 'OCEF\DonationAPI\Controllers\ActivityController');

        Route::get('donations/search', 'OCEF\DonationAPI\Controllers\DonationController@search');
        Route::resource('donations', 'OCEF\DonationAPI\Controllers\DonationController');

        Route::get('payments/search', 'OCEF\DonationAPI\Controllers\PaymentController@search');
        Route::resource('payments', 'OCEF\DonationAPI\Controllers\PaymentController');

        Route::get('accounts/search', 'OCEF\DonationAPI\Controllers\AccountController@search');
        Route::resource('accounts', 'OCEF\DonationAPI\Controllers\AccountController');

        Route::get('stakeholders/search', 'OCEF\DonationAPI\Controllers\StakeholderController@search');
        Route::resource('stakeholders', 'OCEF\DonationAPI\Controllers\StakeholderController');

        Route::get('matching-gifts/search', 'OCEF\DonationAPI\Controllers\MatchingGiftController@search');
        Route::resource('matching-gifts', 'OCEF\DonationAPI\Controllers\MatchingGiftController');

    });
