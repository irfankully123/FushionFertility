<?php

use App\Http\Controllers\Admin\AppUserController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::group(['middleware' => ['role:super']], function () {

    Route::prefix('user')->group(function () {

        Route::get('/', [AppUserController::class, 'index'])
            ->name('dashboard.user');


        Route::delete('/{user}', [AppUserController::class, 'destroy'])
            ->name('dashboard.user.destroy');

        Route::post('/assign/permission/{user}', [AppUserController::class, 'assignPermission'])
            ->name('dashboard.user.assignPermission');

        Route::delete('/revoke/permission/{user}', [AppUserController::class, 'revokePermission'])
            ->name('dashboard.user.revokePermission');

        Route::get('/permission/{user}', [AppUserController::class, 'userPermissions'])
            ->name('dashboard.user.permissions');


        Route::get('/store/form', function () {
            return Inertia::render('Admin/AppUsers/AppUserCreate');
        })->name('dashboard.user.showStoreForm');


        Route::post('/store', [AppUserController::class, 'store'])
            ->name('dashboard.user.store');

        Route::get('/edit/form/{user}', function (User $user) {
            return Inertia::render('Admin/AppUsers/AppUserUpdate', compact('user'));
        })->name('dashboard.user.showEditForm');

        Route::post('/update/{user}', [AppUserController::class, 'update'])
            ->name('dashboard.user.update');

    });

});


