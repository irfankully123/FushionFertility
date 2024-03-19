<?php


use App\Http\Controllers\Admin\AppointmentController;
use App\Http\Controllers\Admin\BlogCategoryController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\DoctorController;
use App\Http\Controllers\Admin\InvoiceController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\TransactionController;
use App\Models\BlogCategory;
use App\Models\Blogs;
use App\Models\Doctor;
use App\Models\Patient;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::group(['middleware' => ['role:super|admin']], function () {

    Route::prefix('doctor')->group(function () {

        Route::get('/', [DoctorController::class, 'index'])
            ->middleware('can:show')
            ->name('dashboard.doctor');

        Route::post('/store', [DoctorController::class, 'store'])
            ->middleware('can:create')
            ->name('dashboard.doctor.store');

        Route::post('/update/{doctor}', [DoctorController::class, 'update'])
            ->middleware('can:update')
            ->name('dashboard.doctor.update');

        Route::delete('/delete/{doctor}', [DoctorController::class, 'destroy'])
            ->middleware('can:delete')
            ->name('dashboard.doctor.delete');

        Route::get('/create/form', function () {
            return Inertia::render('Admin/Doctors/DoctorCreate');
        })->middleware('can:create')->name('dashboard.doctor.create');

        Route::get('/edit/{doctor}', function (Doctor $doctor) {
            return Inertia::render('Admin/Doctors/DoctorUpdate', [
                'doctor' => $doctor,
                'user' => $doctor->user()->first(),
                'schedules' => $doctor->schedules()->get(),
                'tags' => $doctor->specialities()->get(),
                'image' => $doctor->user()->first()->profile,
                'zoom' => $doctor->zoomAccess()->first()
            ]);
        })->middleware('can:update')->name('dashboard.doctor.edit');

        Route::get('/detail/{doctor}', function (Doctor $doctor) {
            return Inertia::render('Admin/Doctors/DoctorDetail', [
                'doctor' => $doctor,
                'user' => $doctor->user()->firstOr(),
                'schedules' => $doctor->schedules()->get(),
                'tags' => $doctor->specialities()->get(),
                'image' => asset('storage/users/' . $doctor->user()->first()->profile)
            ]);
        })->middleware('can:show')->name('dashboard.doctor.detail');

    });


    Route::prefix('patients')->group(function () {

        Route::get('/', [PatientController::class, 'index'])
            ->middleware('can:show')
            ->name('dashboard.patients');

        Route::get('/store/form', function () {
            return Inertia::render('Admin/Patients/PatientCreate');
        })->middleware('can:create')->name('dashboard.patients.storeForm');

        Route::post('/store/form', [PatientController::class, 'store'])
            ->middleware('can:create')
            ->name('dashboard.patients.store');

        Route::get('/edit/form/{patient}', function (Patient $patient) {
            return Inertia::render('Admin/Patients/PatientUpdate', [
                'patient' => $patient,
                'user' => $patient->user()->first(),
            ]);
        })->middleware('can:update')->name('dashboard.patients.editForm');

        Route::post('/update/form/{patient}', [PatientController::class, 'update'])
            ->middleware('can:update')
            ->name('dashboard.patients.update');

        Route::delete('/delete/patient/{patient}', [PatientController::class, 'destroy'])
            ->middleware('can:delete')
            ->name('dashboard.patients.delete');

    });

    Route::prefix('appointments')->group(function () {

        Route::get('/', [AppointmentController::class, 'index'])
            ->middleware('can:show')
            ->name('dashboard.appointments');

        Route::post('/store', [AppointmentController::class, 'store'])
            ->middleware('can:create')
            ->name('dashboard.appointments.store');

        Route::post('/update/{appointment}', [AppointmentController::class, 'update'])
            ->middleware('can:update')
            ->name('dashboard.appointments.update');

        Route::delete('/destroy/{appointment}', [AppointmentController::class, 'destroy'])
            ->middleware('can:delete')
            ->name('dashboard.appointments.destroy');
    });

    Route::prefix('invoices')->group(function () {

        Route::get('/', [InvoiceController::class, 'index'])
            ->middleware('can:show')
            ->name('dashboard.invoices');

        Route::get('/generate/pdf/{invoice}', [InvoiceController::class, 'pdfGenerate'])
            ->name('dashboard.invoices.generatePdf');

    });

    Route::prefix('transactions')->group(function () {

        Route::get('/', [TransactionController::class, 'index'])
            ->middleware('can:show')
            ->name('dashboard.transactions');

    });

    Route::prefix('blog-category')->group(function () {

        Route::get('/', [BlogCategoryController::class, 'index'])
            ->middleware('can:show')
            ->name('dashboard.blog.category');

        Route::post('/create/blogcategory', [BlogCategoryController::class, 'store'])
            ->middleware('can:create')
            ->name('dashboard.blog.categoryStore');

        Route::post('/update/blogcategory/{blogCategory}', [BlogCategoryController::class, 'update'])
            ->middleware('can:update')
            ->name('dashboard.blog.categoryUpdate');

        Route::delete('/delete/blogcategory/{blogCategory}', [BlogCategoryController::class, 'destroy'])
            ->middleware('can:delete')
            ->name('dashboard.blog.categoryDestroy');

    });

    Route::prefix('blogs')->group(function () {

        Route::get('/', [BlogController::class, 'index'])
            ->middleware('can:show')
            ->name('dashboard.blogs');

        Route::get('/create/blog', function () {
            return Inertia::render('Admin/Blogs/CreateBlog', [
                'categories' => BlogCategory::all()->toArray(),
            ]);
        })->middleware('can:create')->name('dashboard.blogs.create');

        Route::get('/edit/blog/{blog}', function (Blogs $blog) {
            return Inertia::render('Admin/Blogs/UpdateBlog', [
                'blog' => $blog,
                'categories' => BlogCategory::all()->toArray()
            ]);
        })->middleware('can:update')->name('dashboard.blogs.edit');

        Route::post('/store/blog', [BlogController::class, 'store'])
            ->middleware('can:create')
            ->name('dashboard.blog.store');

        Route::post('/update/blog', [BlogController::class, 'update'])
            ->middleware('can:delete')
            ->name('dashboard.blog.update');

        Route::delete('/delete/blog/{blogs}', [BlogController::class, 'destroy'])
            ->middleware('can:delete')
            ->name('dashboard.blog.destroy');

    });

});



