<?php

use App\Http\Controllers\Organizer\AnnouncementController;
use App\Http\Controllers\Organizer\AttendanceController;
use App\Http\Controllers\Organizer\CertificateController;
use App\Http\Controllers\Organizer\DashboardController;
use App\Http\Controllers\Organizer\EventController;
use App\Http\Controllers\Organizer\MediaController;
use App\Http\Controllers\Organizer\RegistrationController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:organizer'])->prefix('organizer')->name('organizer.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('events', EventController::class)->except(['destroy']);
    Route::post('events/{event}/cancel', [EventController::class, 'cancel'])->name('events.cancel');
    Route::patch('registrations/{registration}', [RegistrationController::class, 'update'])->name('registrations.update');
    Route::get('attendance/scan', [AttendanceController::class, 'scan'])->name('attendance.scan');
    Route::post('attendance/checkin', [AttendanceController::class, 'checkin'])->name('attendance.checkin');
    Route::get('events/{event}/attendance', [AttendanceController::class, 'report'])->name('attendance.report');
    Route::get('events/{event}/certificates', [CertificateController::class, 'index'])->name('certificates.index');
    Route::post('events/{event}/certificates', [CertificateController::class, 'store'])->name('certificates.store');
    Route::get('media', [MediaController::class, 'index'])->name('media.index');
    Route::post('media', [MediaController::class, 'store'])->name('media.store');
    Route::delete('media/{media}', [MediaController::class, 'destroy'])->name('media.destroy');
    Route::get('events/{event}/announcements/create', [AnnouncementController::class, 'create'])->name('announcements.create');
    Route::post('events/{event}/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');
});
