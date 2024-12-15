<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\DambadiwaProjectController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
Route::get('/user/register', [UserController::class, 'create'])->name('user.register');
Route::post('/user/register', [UserController::class, 'store'])->name('user.store');
Route::get('/user/search', [UserController::class, 'search'])->name('user.search');
Route::get('/user/reports', [UserController::class, 'reports'])->name('user.reports');
Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');

Route::get('/follower/dashboard', [FollowerController::class, 'followerindex'])->name('follower.dashboard');
Route::get('/follower/register', [FollowerController::class, 'followercreate'])->name('follower.register');
Route::post('/follower/register', [FollowerController::class, 'followerstore'])->name('follower.store');
Route::get('/follower/search', [FollowerController::class, 'followersearch'])->name('follower.search');
Route::get('/follower/reports', [FollowerController::class, 'followerreports'])->name('follower.reports');
Route::get('/follower/profile', [FollowerController::class, 'followerprofile'])->name('follower.profile');

Route::get('/dambadiwa/dashboard', [DambadiwaProjectController::class, 'dambadiwaindex'])->name('dambadiwa.dashboard');
Route::get('/dambadiwa/register', [DambadiwaProjectController::class, 'dambadiwacreate'])->name('dambadiwa.register');
Route::post('/dambadiwa/register', [DambadiwaProjectController::class, 'dambadiwastore'])->name('dambadiwa.store');
Route::get('/dambadiwa/search', [DambadiwaProjectController::class, 'dambadiwasearch'])->name('dambadiwa.search');
Route::get('/dambadiwa/reports', [DambadiwaProjectController::class, 'dambadiwareports'])->name('dambadiwa.reports');
Route::get('/dambadiwa/profile', [DambadiwaProjectController::class, 'dambadiwaprofile'])->name('dambadiwa.profile');

require __DIR__.'/auth.php';
