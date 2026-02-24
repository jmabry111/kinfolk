<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
  ->middleware(['auth', 'verified'])
  ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

use App\Http\Controllers\FamilyGroupController;

Route::middleware('auth')->group(function () {
    Route::resource('family-groups', FamilyGroupController::class)
        ->except(['edit', 'update']);
});

use App\Http\Controllers\ContactController;

Route::prefix('family-groups/{familyGroup}')->group(function () {
    Route::get('contacts/create', [ContactController::class, 'create'])->name('contacts.create');
    Route::post('contacts', [ContactController::class, 'store'])->name('contacts.store');
    Route::get('contacts/{contact}', [ContactController::class, 'show'])->name('contacts.show');
    Route::get('contacts/{contact}/edit', [ContactController::class, 'edit'])->name('contacts.edit');
    Route::put('contacts/{contact}', [ContactController::class, 'update'])->name('contacts.update');
    Route::delete('contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');
});

use App\Http\Controllers\GiftController;

Route::prefix('family-groups/{familyGroup}/contacts/{contact}')->group(function () {
    Route::get('gifts/create', [GiftController::class, 'create'])->name('gifts.create');
    Route::post('gifts', [GiftController::class, 'store'])->name('gifts.store');
    Route::get('gifts/{gift}/edit', [GiftController::class, 'edit'])->name('gifts.edit');
    Route::put('gifts/{gift}', [GiftController::class, 'update'])->name('gifts.update');
    Route::patch('gifts/{gift}/toggle-purchased', [GiftController::class, 'togglePurchased'])->name('gifts.toggle-purchased');
    Route::delete('gifts/{gift}', [GiftController::class, 'destroy'])->name('gifts.destroy');
});

use App\Http\Controllers\GroupInviteController;

// Inside the auth middleware group:
Route::get('family-groups/{familyGroup}/invite', [GroupInviteController::class, 'create'])
    ->name('invites.create');

// Outside the auth middleware group (invite links work for non-logged-in users):
Route::get('invites/{token}', [GroupInviteController::class, 'accept'])
  ->name('invites.accept');

require __DIR__.'/auth.php';
