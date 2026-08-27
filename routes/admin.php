<?php

use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventApprovalController;
use App\Http\Controllers\Admin\ModerationController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\UserManagementController;
use App\Http\Controllers\Admin\ContactMessageController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes  (include this file from routes/web.php with:)
|   require __DIR__.'/admin.php';
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {

    Route::get('/', DashboardController::class . '@index')->name('dashboard');

    // Event approvals
    Route::get('/events/pending', [EventApprovalController::class, 'index'])->name('events.pending');
    Route::get('/events/{event}', [EventApprovalController::class, 'show'])->name('events.show');
    Route::post('/events/{event}/approve', [EventApprovalController::class, 'approve'])->name('events.approve');
    Route::post('/events/{event}/reject', [EventApprovalController::class, 'reject'])->name('events.reject');

    // User management
    Route::get('/users', [UserManagementController::class, 'index'])->name('users.index');
    Route::patch('/users/{user}/role', [UserManagementController::class, 'updateRole'])->name('users.role');
    Route::patch('/users/{user}/status', [UserManagementController::class, 'toggleStatus'])->name('users.status');
    Route::patch('/users/{user}/password', [UserManagementController::class, 'resetPassword'])->name('users.password');
    Route::delete('/users/{user}', [UserManagementController::class, 'destroy'])->name('users.destroy');

    // Content moderation
    Route::get('/moderation/feedback', [ModerationController::class, 'feedback'])->name('moderation.feedback');
    Route::patch('/moderation/feedback/{feedback}/{status}', [ModerationController::class, 'updateFeedbackStatus'])->name('moderation.feedback.status');
    Route::get('/moderation/gallery', [ModerationController::class, 'gallery'])->name('moderation.gallery');
    Route::patch('/moderation/gallery/{media}/{status}', [ModerationController::class, 'updateMediaStatus'])->name('moderation.gallery.status');

    // Announcements
    Route::get('/announcements', [AnnouncementController::class, 'index'])->name('announcements.index');
    Route::get('/announcements/create', [AnnouncementController::class, 'create'])->name('announcements.create');
    Route::post('/announcements', [AnnouncementController::class, 'store'])->name('announcements.store');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/participation/{format?}', [ReportController::class, 'participation'])->name('reports.participation');
    Route::get('/reports/user-growth', [ReportController::class, 'userGrowth'])->name('reports.user-growth');

    // Contact inquiries
    Route::get('/contacts', [ContactMessageController::class, 'index'])->name('contacts.index');
    Route::delete('/contacts/{contact}', [ContactMessageController::class, 'destroy'])->name('contacts.destroy');
});
