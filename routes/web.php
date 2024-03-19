<?php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\UserProfile;
use App\Http\Controllers\Auth\GoogleAuthentication;
use App\Http\Controllers\Auth\ZoomAuthController;
use App\Http\Controllers\Web\AppointmentBooking;
use App\Http\Controllers\Web\DoctorListing;
use App\Http\Controllers\Web\PatientDashboardController;
use App\Http\Controllers\Web\RatingController;
use App\Http\Controllers\Web\StripeController;
use App\Http\Controllers\Web\TimeZoneController;
use App\Http\Controllers\Web\WebBlogController;
use App\Http\Controllers\Web\WebHomeController;
use App\Models\User;
use Illuminate\Support\Facades\Route;


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

require __DIR__ . '/auth.php';


// Route::get('/storage-link', function () {
//     Artisan::call('storage:link');

//     return 'Storage link created successfully!';
// });



Route::get('/', [WebHomeController::class, 'index'])->name('home');

Route::post('/set-timezone', TimeZoneController::class)->name('set.timezone');

Route::get('/doctors', DoctorListing::class)->name('doctors.listing');

Route::get('/blogs', [WebBlogController::class, 'index'])->name('blogs');

Route::get('/blogs/blog/{id}', [WebBlogController::class, 'blogSingle'])->name("blogs.single");

Route::get('blogs/category/{category}', [WebBlogController::class, 'categoryBlogs'])->name('blogs.category');


Route::middleware(['auth', 'verified'])->group(function () {


    Route::post('/rate/store/{sessionRating}', [RatingController::class, 'store'])->name('doctor.rating.store');

    Route::get('/rate/cancel/{sessionRating}', [RatingController::class, 'cancel'])->name('doctor.rating.cancel');


    Route::get('/doctor/overview/{doctor}', [WebHomeController::class, 'doctorOverview'])->name('doctor.overview');

    Route::middleware('patient.existAlready')->group(function () {
        Route::view('patient/form', 'web.Pages.patient_form')->name('patient.dashboard.form');

        Route::post('patient/form/store/{user}', [PatientDashboardController::class, 'storeAsPatient'])->name('patient.dashboard.store');
    });

    Route::middleware('check.patient')->group(function () {
        Route::prefix('patient')->group(function () {

            Route::get('/dashboard/{user}', [PatientDashboardController::class, 'index'])->name('patient.dashboard');

            Route::get('/dashboard/appointment/{appointment}', [PatientDashboardController::class, 'destroy'])->name('patient.appointment.destroy');

            Route::get('/dashboard/profile/{user}', function (User $user) {
                return view('web.Pages.patient_dashboard_profile', ['patient' => $user->patient()->first()]);
            })->name('patient.dashboard.profile');

            Route::put('/dashboard/profile/{user}', [PatientDashboardController::class, 'UpdateAsPatient'])->name('patient.dashboard.update');

            Route::get('/dashboard/patient/appointment/history/{user}', [PatientDashboardController::class, 'AppointmentHistory'])->name('patient.dashboard.appointmentHistory');

            Route::get('/dashboard/patient/appointment/schedule/{user}', [PatientDashboardController::class, 'scheduleAppointments'])->name('patient.dashboard.schedule.appointments');
        });

        Route::prefix('appointment')->group(function () {

            Route::get('/booking/{doctor}', [AppointmentBooking::class, 'index'])->name('appointment.booking');

            Route::post('/booking/{doctor}', [AppointmentBooking::class, 'booking'])->name('appointment.booking.post');


            Route::post('/checkout/{appointment}', [StripeController::class, 'createCheckoutSession'])->name('appointment.checkout');

            Route::get('/payment/success/{appointment}', [StripeController::class, 'paymentSuccessful'])->name('payment.success');

            Route::get('/payment/cancel', [StripeController::class, 'paymentCancel'])->name('payment.cancel');
        });
    });
});

Route::middleware(['auth', 'verified'])->prefix('dashboard')->group(function () {

    Route::group(['middleware' => ['role:super|admin|doctor']], function () {

        Route::get('/home', [HomeController::class, 'index'])->name('dashboard.home');

        Route::get('/auth/profile', [UserProfile::class, 'index'])->name('dashboard.auth.show');

        Route::post('/auth/profile', [UserProfile::class, 'update'])->name('dashboard.auth.update');

        Route::get('/auth/profile/attach/zoom/{doctor}', [UserProfile::class, 'attachZoom'])->name('attach.zoom');
    });

    require __DIR__ . '/doctor.php';
    require __DIR__ . '/admin.php';
    require __DIR__ . '/superadmin.php';
});

Route::get('/login/google', [GoogleAuthentication::class, 'redirectToGoogle'])->name('google.login');
Route::get('/login/google/callback', [GoogleAuthentication::class, 'handleGoogleCallback']);

Route::get('/zoom/oauth/redirect', [ZoomAuthController::class, 'redirectToZoom'])->name('zoomRedirect');
Route::get('/zoom/oauth/handleCallback', [ZoomAuthController::class, 'handleCallback']);

Route::view('/terms', 'auth.terms');
Route::view('/policies', 'auth.polices');
