<?php
use App\Services\Route;
use App\Middleware\Auth;
use App\Middleware\Guest;

Route::get('', 'HomeController', 'index');
Route::get('login', 'LoginController', 'index', [Guest::class]);
Route::get('register', 'RegisterController', 'index', [Guest::class]);
Route::post('submit-login', 'LoginController', 'login');
Route::post('submit-register', 'RegisterController', 'register');
Route::get('logout', 'DashboardController', 'logout', [Auth::class]);
Route::get('dashboard', 'DashboardController', 'index', [Auth::class]);