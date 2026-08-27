<?php

use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes  (include from routes/web.php with:)
|   require __DIR__.'/public.php';
|--------------------------------------------------------------------------
| No auth middleware — matches SRS "Normal Student (Visitor)" role.
*/

Route::get('/', [PublicController::class, 'home'])->name('home');

Route::get('/events', [PublicController::class, 'events'])->name('events.index');
Route::get('/events/{event}', [PublicController::class, 'eventShow'])->name('events.show');

Route::get('/gallery', [PublicController::class, 'gallery'])->name('gallery.index');

Route::get('/about', [PublicController::class, 'about'])->name('about');

Route::get('/contact', [PublicController::class, 'contact'])->name('contact');
Route::post('/contact', [PublicController::class, 'contactSubmit'])->name('contact.submit');

Route::get('/faq', [PublicController::class, 'faq'])->name('faq');

Route::get('/sitemap', [PublicController::class, 'sitemap'])->name('sitemap');
