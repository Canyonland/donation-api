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

        if (strtolower(env('APP_ENV')) != 'prod') {
            Route::get('/fake/{count}/{model}', 'OCEF\DonationAPI\Fake\FakeController@fake');
            Route::get('/clean-house', 'OCEF\DonationAPI\Fake\FakeController@cleanHouse');
        }

    });

/*
if (strtolower(env('APP_ENV')) != 'prod') {
    Route::prefix('/demo')->group(function () {
        Route::get('/', 'OCEF\DonationPublic\Demo\HomeController@home');

        Route::get('/fake/{count}/{model}', 'OCEF\DonationPublic\Demo\HomeController@fake');
        Route::get('/clean-house', 'OCEF\DonationPublic\Demo\HomeController@cleanHouse');

        Route::resource('/accounts', 'OCEF\DonationPublic\Demo\AccountController');
        Route::resource('/activities', 'OCEF\DonationPublic\Demo\ActivityController');
        Route::resource('/donations', 'OCEF\DonationPublic\Demo\DonationController');
        Route::resource('/payments', 'OCEF\DonationPublic\Demo\PaymentController');
        Route::resource('/stakeholders', 'OCEF\DonationPublic\Demo\StakeholderController');
        Route::resource('/users', 'OCEF\DonationPublic\Demo\UserController');
    });
}*/