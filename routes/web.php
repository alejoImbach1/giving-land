<?php

use App\Http\Controllers\AppController;
use App\Http\Controllers\CodeValidationController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ResetPasswordController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\UserController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::view('/', 'welcome');

Route::get('p', function () {
    // $credentials = array(
    //     'email' => 'alejoimbachihoyos@gmail.com',
    //     'password' => 'buenas'
    // );
    // Auth::attempt($credentials);
    // Auth::logout();
    // return session()->invalidate();
    // session(['hola'=>'valor']);
    // session(['hola_timeout'=>now()->addSeconds(10)]);
    // if (now() > session('hola_timeout')) {
    //     session()->forget('hola');
    //     session()->forget('hola_timeout');
    // }
    return User::factory()->create([
        'name' => 'care monda jeje jeje',
        'email' => 'care@gmail.com',
        'password' => Hash::make('buenas')
    ])->save();
});

Route::get('/all', function () {
    return session()->all();
});
Route::get('/invalidate', function () {
    return session()->invalidate();
});

Route::view('vp', 'prueba');


Route::get('/google-auth/redirect', function () {
    return Socialite::driver('google')->redirect();
});

Route::get('/google-auth/callback', function () {
    $user_google = Socialite::driver('google')->stateless()->user();
    // dd($user_google);
    $user = User::updateOrCreate([
        'google_id' => $user_google->id,
    ], [
        'username' => str_replace(" ", "_", strtolower($user_google->name)) . "_" . $user_google->id,
        'name' => $user_google->name,
        'email' => $user_google->email,
        'profile_img' => $user_google->avatar,
    ]);
    Auth::login($user);
    Session()->regenerate();
    return to_route('home');
});

Route::controller(AppController::class)->group(function () {
    Route::get('/', 'init')->name('home');

    Route::post('/logout', 'logout')->name('app.logout');

    Route::get('/settings', 'settings')->name('app.settings');
});

Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'index')->name('login.index');
    Route::post('/login', 'authenticate')->name('login.authenticate');
});

Route::controller(SignupController::class)->group(function () {
    Route::get('/signup', 'index')->name('signup.index');
    Route::post('/signup/send-code', 'sendCode')->name('signup.sendCode');
});

Route::controller(CodeValidationController::class)->group(function () {
    Route::get('/code-form', 'codeForm')->name('codeValidation.codeForm');
    Route::post('/verify-code', 'verifyCode')->name('codeValidation.verifyCode');
    Route::get('/cp', 'prueba')->name('codeValidation.prueba');
});

Route::controller(ResetPasswordController::class)->group(function () {
    Route::get('/reset-password', 'emailResetPasswordForm')->name('resetPassword.emailResetPasswordForm');
    Route::post('/reset-password/send-code', 'sendResetPasswordCode')->name('resetPassword.sendResetPasswordCode');
    Route::get('/reset-password/new-password-form/{token}', 'newPasswordForm')->name('resetPassword.newPasswordForm');
    Route::post('/reset-password/save-new-password', 'saveNewPassword')->name('resetPassword.saveNewPassword');
});

Route::resource('users.products', ProductController::class);

Route::resource('users', UserController::class);
