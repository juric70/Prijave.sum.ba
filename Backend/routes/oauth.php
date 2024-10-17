<?php

use App\Http\Controllers\OAuthController;

Route::get('login', [OAuthController::class, 'redirectToProvider'])->name('login');
Route::get('callback', [OAuthController::class, 'handleProviderCallback'])->name('oauth_callback');
Route::get('user', [OAuthController::class, 'getUser'])->name('user');
Route::get('logout', [OAuthController::class, 'logout'])->name('logout');