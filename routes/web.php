<?php
use App\Http\Controllers\UrlController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WebController;




Route::get('/', [WebController::class, 'home'])->name('home');
Route::post('/urls', [WebController::class, 'store'])->name('urls.create');
Route::get('/u/{shortCode}', [WebController::class, 'redirect'])->name('urls.redirect');