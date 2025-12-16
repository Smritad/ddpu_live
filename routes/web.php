<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Http;
// Backend controller
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\home\BannerDetailsController;
use App\Http\Controllers\Backend\home\AimDetailsController;
use App\Http\Controllers\Backend\home\WhychooseDetailsController;
use App\Http\Controllers\Backend\home\TestimonialsDetailsController;
use App\Http\Controllers\Backend\home\JoinmembershipDetailsController;
use App\Http\Controllers\Backend\home\FooterDetailsController;
use App\Http\Controllers\Backend\home\MembershipDetailsController;
use App\Http\Controllers\Backend\home\FilesDetailsController;
use App\Http\Controllers\Backend\home\PaperlessDetailsController;
use App\Http\Controllers\Backend\home\SubmissionsRemindersController;
use App\Http\Controllers\Backend\home\TransactionDetailsController;


//frontend controller
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\JoinmembershipApplicationController;
use App\Http\Controllers\Frontend\SignupController;
use App\Http\Controllers\BankValidationController;



// Backend
Route::get('/admin-login', [LoginController::class, 'login'])->name('admin.login');
Route::post('/admin-login', [LoginController::class, 'authenticate'])->name('admin.authenticate');
Route::get('/admin-logout', [LoginController::class, 'logout'])->name('admin.logout');
Route::get('/change-password', [LoginController::class, 'change_password'])->name('admin.changepassword');
Route::post('/update-password', [LoginController::class, 'updatePassword'])->name('admin.updatepassword');
Route::get('/admin-register', [LoginController::class, 'register'])->name('admin.register');
Route::post('/register', [LoginController::class, 'authenticate_register'])->name('admin.register.authenticate');


//Backend home pages 
Route::resource('banner-details', BannerDetailsController::class);
Route::resource('aim-details', AimDetailsController::class);
Route::resource('whychoose-details', WhychooseDetailsController::class);
Route::resource('testimonials-details', TestimonialsDetailsController::class);
Route::resource('joinmembership-details', JoinmembershipDetailsController::class);
Route::resource('footer-details', FooterDetailsController::class);

//Backend Customer
Route::get('/membership-detail', [MembershipDetailsController::class, 'index'])->name('membership.details');
Route::get('/admin/membership/{id}', [MembershipDetailsController::class, 'show'])->name('membership.show');

//Backend Files
Route::get('/files-detail', [FilesDetailsController::class, 'index'])->name('files.details');
Route::post('/files/import',   [FilesDetailsController::class, 'import'])->name('files.import');
Route::get('/files/export/{id}', [FilesDetailsController::class, 'export'])->name('files.export');

//Backend Paperless
Route::get('/paperless-detail', [PaperlessDetailsController::class,'index'])->name('direct_debit.index');
Route::get('/create', [PaperlessDetailsController::class,'create'])->name('direct_debit.create');
Route::post('/store', [PaperlessDetailsController::class,'store'])->name('direct_debit.store');
Route::post('/download', [PaperlessDetailsController::class,'download'])->name('direct_debit.download');
Route::post('/process', [PaperlessDetailsController::class,'process'])->name('direct_debit.process');
Route::post('/mark-processed', [PaperlessDetailsController::class,'markProcessed'])->name('direct_debit.markProcessed');
Route::get('/edit/{id}', [PaperlessDetailsController::class, 'edit'])->name('direct_debit.edit');
Route::post('/update/{id}', [PaperlessDetailsController::class, 'update'])->name('direct_debit.update');


//Backend SubmissionsReminders
Route::get('/Submissions-schedules', [SubmissionsRemindersController::class,'index'])->name('Submissionsschedules.index');

//Backend Transaction
Route::get('/transaction-detail', [TransactionDetailsController::class,'index'])->name('transaction.details');

Route::get('/file-details/export', [TransactionDetailsController::class, 'exportCsv'])
    ->name('file.details.export');

// // Admin Routes with Middleware
Route::group(['middleware' => ['auth:web', \App\Http\Middleware\PreventBackHistoryMiddleware::class]], function () {
    Route::get('/dashboard', function () {
            return view('backend.dashboard'); 
        })->name('admin.dashboard');
});


// API locate

// Route::get('/login', function() {
//     return 'Login route placeholder';
// });


// Route::get('/loqate', function () {
//     return view('loqate-test');
// });

// Route::post('/loqate/lookup', function (Request $request) {
//     $key = env('LOQATE_API_KEY');
//     $address = $request->input('address');

//     $response = Http::get("https://api.addressy.com/Capture/Interactive/Find/v1.10/json3.ws", [
//         'Key' => $key,
//         'Text' => $address,
//         'IsMiddleware' => false
//     ]);

//     return response()->json($response->json());
// });



// Route::get('/', function () {return view('welcome');});
Route::get('/', [HomeController::class, 'home'])->name('frontend.index');
Route::get('/join-membership', [JoinmembershipApplicationController::class, 'index'])->name('joinmembership.form');

Route::get('/application-form', [JoinmembershipApplicationController::class, 'create'])->name('application.create');

Route::post('/application/save-step', [JoinmembershipApplicationController::class, 'saveStep'])
    ->name('application.saveStep');

Route::post('/application/submit', [JoinmembershipApplicationController::class, 'submitApplication'])
    ->name('application.submit');

Route::get('/application/saved', [JoinmembershipApplicationController::class, 'getSavedApplication'])
    ->name('application.saved');

Route::get('/Signup-form/{id}', [SignupController::class, 'index'])->name('signup.form');


Route::post('/signup/step1-save', [SignupController::class, 'saveStep1']);
Route::post('/signup/final-submit', [SignupController::class, 'finalSubmit']);


Route::get('/proxy-bank-validation', [BankValidationController::class, 'validateBank']);
Route::get('/signup/step2/pdf/{userId}', [SignupController::class, 'generatePdf']);
