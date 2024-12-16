<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;

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


Route::get('/', [AuthController::class, 'index'])->name('login');
Route::post('post-login', [AuthController::class, 'postLogin'])->name('login.post');
Route::get('register', [AuthController::class, 'registration'])->name('register');
Route::post('post-registration', [AuthController::class, 'postRegistration'])->name('register.post');
Route::get('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['admin'])->group(function () {
    Route::get('admin/dashboard', [AuthController::class, 'dashboard'])->name('admin.dashboard');


    Route::get('admin/addresses', [AuthController::class, 'addresses'])->name('admin.addresses');
    Route::get('admin/create/addresses', [AuthController::class, 'createaddresses'])->name('admin.create.route');
    Route::post('admin/store/addresses', [AuthController::class, 'addressesStore'])->name('addresses.store');
});

// User Routes
Route::middleware(['user'])->group(function () {
    Route::get('user/home', [AuthController::class, 'user'])->name('user.home');
});