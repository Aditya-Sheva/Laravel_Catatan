<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\NoteController;
use App\Http\Controllers\GambarController;
use App\Http\Controllers\AdminController; // ✅ WAJIB

Route::get('/', function () {
    return view('welcome');
});

// ===== AUTH =====
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ===== USER NOTES =====
Route::middleware('auth')->group(function () {
    Route::resource('notes', NoteController::class);
});

// ===== GAMBAR =====
Route::resource('gambars', GambarController::class);

// ===== ADMIN ONLY =====
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/users', [AdminController::class, 'users'])->name('admin.users');
    Route::get('/admin/users/{userId}/notes', [AdminController::class, 'userNotes'])->name('admin.user-notes');
    Route::delete('/admin/notes/{noteId}', [AdminController::class, 'deleteNote'])->name('admin.delete-note');
});
