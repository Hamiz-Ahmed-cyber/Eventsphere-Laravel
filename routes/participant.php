<?php

use App\Http\Controllers\Participant\BookmarkController;
use App\Http\Controllers\Participant\CertificateController;
use App\Http\Controllers\Participant\DashboardController;
use App\Http\Controllers\Participant\EventController;
use App\Http\Controllers\Participant\FeedbackController;
use App\Http\Controllers\Participant\ProfileController;
use App\Http\Controllers\Participant\RegistrationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Participant Routes  (include from routes/web.php with:)
|   require __DIR__.'/participant_routes.php';
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:participant'])->prefix('participant')->name('participant.')->group(function () {

    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

    // Browse + register for events
    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::post('/events/{event}/register', [EventController::class, 'register'])->name('events.register');

    // My registrations
    Route::get('/registrations', [RegistrationController::class, 'index'])->name('registrations.index');
    Route::patch('/registrations/{registration}/cancel', [RegistrationController::class, 'cancel'])->name('registrations.cancel');

    // Certificates
    Route::get('/certificates', [CertificateController::class, 'index'])->name('certificates.index');
    Route::post('/certificates/{certificate}/pay', [CertificateController::class, 'pay'])->name('certificates.pay');

    // Feedback
    Route::get('/feedback/{event}', [FeedbackController::class, 'create'])->name('feedback.create');
    Route::post('/feedback/{event}', [FeedbackController::class, 'store'])->name('feedback.store');

    // Bookmarks
    Route::get('/bookmarks', [BookmarkController::class, 'index'])->name('bookmarks.index');
    Route::post('/bookmarks/{event}', [BookmarkController::class, 'store'])->name('bookmarks.store');
    Route::delete('/bookmarks/{bookmark}', [BookmarkController::class, 'destroy'])->name('bookmarks.destroy');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});
