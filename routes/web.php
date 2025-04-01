<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\DambadiwaProjectController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ExcelController;
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
    if (Auth::check()) {
        return redirect()->route('dashboard');
    }
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/user/dashboard', [UserController::class, 'index'])->name('user.dashboard');
    Route::get('/user/register', [UserController::class, 'create'])->name('user.register');
    Route::post('/user/register', [UserController::class, 'store'])->name('user.store');
    Route::get('/user/search', [UserController::class, 'search'])->name('user.search');
    Route::get('/user/reports', [UserController::class, 'reports'])->name('user.reports');
    Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');

    Route::get('/follower/dashboard', [FollowerController::class, 'index'])->name('follower.dashboard');
    Route::get('/follower/register', [FollowerController::class, 'create'])->name('follower.register');
    Route::post('/follower/register', [FollowerController::class, 'store'])->name('follower.store');
    Route::get('/follower/search', [FollowerController::class, 'search'])->name('follower.search');
    Route::get('/follower/reports', [FollowerController::class, 'reports'])->name('follower.reports');
    Route::get('/follower/profile', [FollowerController::class, 'profile'])->name('follower.profile');

    Route::get('/dambadiwa/dashboard', [DambadiwaProjectController::class, 'index'])->name('dambadiwa.dashboard');
    Route::get('/dambadiwa/register', [DambadiwaProjectController::class, 'create'])->name('dambadiwa.register');
    Route::post('/dambadiwa/register', [DambadiwaProjectController::class, 'store'])->name('dambadiwa.store');
    Route::get('/dambadiwa/search', [DambadiwaProjectController::class, 'search'])->name('dambadiwa.search');
    Route::get('/dambadiwa/reports', [DambadiwaProjectController::class, 'reports'])->name('dambadiwa.reports');
    Route::get('/dambadiwa/project', [DambadiwaProjectController::class, 'project'])->name('dambadiwa.project');
    Route::get('/dambadiwa/project-crew', [DambadiwaProjectController::class, 'project_crew'])->name('dambadiwa.project_crew');

    Route::get('/dambadiwa/profile', [DambadiwaProjectController::class, 'profile'])->name('dambadiwa.profile');
    Route::get('/dambadiwa/project-payment', [DambadiwaProjectController::class, 'project_payment'])->name('dambadiwa.project_payment');
    Route::post('/dambadiwa/project-payment', [DambadiwaProjectController::class, 'project_payment_create'])->name('dambadiwa.project_payment');
    Route::get('/dambadiwa/project-payment-slip', [PdfController::class, 'payment_slip_pdf'])->name('dambadiwa.payment_slip_pdf');
    Route::get('/dambadiwa/peyment-confirm', [DambadiwaProjectController::class, 'payment_confirm'])->name('dambadiwa.payment_confirm');
    Route::get('/dambadiwa/peyment-decline', [DambadiwaProjectController::class, 'payment_decline'])->name('dambadiwa.payment_decline');

    Route::get('/dambadiwa/project/crewregister', [DambadiwaProjectController::class, 'crewcreate'])->name('dambadiwa.crewregister');
    Route::get('/dambadiwa/project/crewlist', [DambadiwaProjectController::class, 'crewlist'])->name('dambadiwa.crewlist');
    Route::get('/dambadiwa/project/{id}/crewreport', [DambadiwaProjectController::class, 'crewreport'])->name('dambadiwa.crewreport');
    Route::get('/dambadiwa/project/crewprofile/', [DambadiwaProjectController::class, 'crewprofile'])->name('dambadiwa.crewprofile');
    Route::post('/dambadiwa/project/edit_crew_profile/', [DambadiwaProjectController::class, 'edit_crew_profile'])->name('dambadiwa.edit_crew_profile');
    Route::get('/dambadiwa/project/crewlistreportpdf/', [PdfController::class, 'crewlistreportpdf'])->name('dambadiwa.crewlistreportpdf');
    Route::get('/dambadiwa/project/crewreportpdf/', [PdfController::class, 'crewreportpdf'])->name('dambadiwa.crewreportpdf');
    Route::get('/dambadiwa/project/crewlistreportexcel/', [ExcelController::class, 'crewlistreportexcel'])->name('dambadiwa.crewlistreportexcel');

    Route::get('/dambadiwa/project-payment-report', [DambadiwaProjectController::class, 'project_payment_report'])->name('dambadiwa.project_payment_report');
    Route::get('/dambadiwa/project-user-payment-report', [DambadiwaProjectController::class, 'project_user_payment_report'])->name('dambadiwa.project_user_payment_report');
    Route::get('/dambadiwa/project-payment-pdf', [PdfController::class, 'project_payment_pdf'])->name('dambadiwa.project_payment_pdf');
    Route::get('/dambadiwa/project-user_payment-pdf', [PdfController::class, 'project_user_payment_pdf'])->name('dambadiwa.project_user_payment_pdf');
    Route::get('/dambadiwa/project-payment-excel', [ExcelController::class, 'project_payment_excel'])->name('dambadiwa.project_payment_excel');
    Route::get('/dambadiwa/project-user-payment-excel', [ExcelController::class, 'project_user_payment_excel'])->name('dambadiwa.project_user_payment_excel');
});

Route::get('/payment', [DambadiwaProjectController::class, 'payment'])->name('payment');
Route::post('/payment', [DambadiwaProjectController::class, 'payment_create'])->name('payment_create');
Route::get('/dambadiwa/peyment-success', [DambadiwaProjectController::class, 'payment_success'])->name('payment_success');


require __DIR__.'/auth.php';
