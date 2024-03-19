<?php

use App\Http\Controllers\Doctor\DoctorAppointmentController;
use App\Http\Controllers\Doctor\DoctorHistoryAppointmentController;
use App\Http\Controllers\Doctor\DoctorHomeController;
use App\Http\Controllers\Doctor\DoctorMeetingAppointmentsController;
use App\Http\Controllers\Doctor\DoctorPatientsController;
use App\Http\Controllers\Doctor\DoctorScheduleAppointmentsController;
use Illuminate\Support\Facades\Route;


Route::group(['middleware' => ['role:doctor']], function () {

    Route::prefix('doctor')->group(function () {

        Route::get('/home', [DoctorHomeController::class, 'index'])->name('dashboard.doctor.home');

        Route::get('/paid/appointments/{user}', [DoctorAppointmentController::class, 'index'])
            ->name('doctor_dashboard.appointmentsPaid');


        Route::get('/schedule/appointments/{user}', [DoctorScheduleAppointmentsController::class, 'index'])
            ->name('doctor_dashboard.appointmentsSchedule');


        Route::get('/meeting/appointments/{user}', [DoctorMeetingAppointmentsController::class, 'index'])
            ->name('doctor_dashboard.appointmentsMeeting');


        Route::post('/meeting/appointments/completed/{appointment}', [DoctorMeetingAppointmentsController::class, 'store'])
            ->name('doctor_dashboard.appointmentsMeetingCompleted');

        Route::get('/history/appointments/{user}', [DoctorHistoryAppointmentController::class, 'index'])
            ->name('doctor_dashboard.appointmentsHistory');

        Route::post('/history/appointments/regen/{appointment}', [DoctorHistoryAppointmentController::class, 'update'])
            ->name('doctor_dashboard.appointmentsHistoryRegen');

        Route::get('/patients', [DoctorPatientsController::class, 'index'])
            ->name('doctor_dashboard.patients');

        Route::get('/patients/detail/{patient}', [DoctorPatientsController::class, 'detail'])
            ->name('doctor_dashboard.patientsDetail');

    });

});

