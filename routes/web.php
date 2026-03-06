<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FamilyGroupController;
use App\Http\Controllers\GiftController;
use App\Http\Controllers\GroupInviteController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WalkthroughController;
use Illuminate\Support\Facades\Route;

// Landing page
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Dashboard
Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Profile
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Family Groups
Route::middleware('auth')->group(function () {
    Route::resource('family-groups', FamilyGroupController::class)
        ->except(['edit', 'update']);
});

// Contacts
Route::middleware('auth')->prefix('family-groups/{familyGroup}')->group(function () {
    Route::get('contacts/create', [ContactController::class, 'create'])->name('contacts.create');
    Route::post('contacts', [ContactController::class, 'store'])->name('contacts.store');
    Route::get('contacts/{contact}', [ContactController::class, 'show'])->name('contacts.show');
    Route::get('contacts/{contact}/edit', [ContactController::class, 'edit'])->name('contacts.edit');
    Route::put('contacts/{contact}', [ContactController::class, 'update'])->name('contacts.update');
    Route::delete('contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');
});

// Gifts
Route::middleware('auth')->prefix('family-groups/{familyGroup}/contacts/{contact}')->group(function () {
    Route::get('gifts/create', [GiftController::class, 'create'])->name('gifts.create');
    Route::post('gifts', [GiftController::class, 'store'])->name('gifts.store');
    Route::get('gifts/{gift}/edit', [GiftController::class, 'edit'])->name('gifts.edit');
    Route::put('gifts/{gift}', [GiftController::class, 'update'])->name('gifts.update');
    Route::patch('gifts/{gift}/toggle-purchased', [GiftController::class, 'togglePurchased'])->name('gifts.toggle-purchased');
    Route::delete('gifts/{gift}', [GiftController::class, 'destroy'])->name('gifts.destroy');
});

// Invites
Route::middleware('auth')->get('family-groups/{familyGroup}/invite', [GroupInviteController::class, 'create'])
    ->name('invites.create');
Route::get('invites/{token}', [GroupInviteController::class, 'accept'])
    ->name('invites.accept');

// Admin
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/users', [AdminController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [AdminController::class, 'show'])->name('users.show');
    Route::patch('/users/{user}/toggle-active', [AdminController::class, 'toggleActive'])->name('users.toggle-active');
    Route::delete('/users/{user}', [AdminController::class, 'destroy'])->name('users.destroy');
});

Route::middleware('auth')->group(function () {
    Route::post('/walkthrough/complete', [WalkthroughController::class, 'complete'])->name('walkthrough.complete');
    Route::post('/walkthrough/reset', [WalkthroughController::class, 'reset'])->name('walkthrough.reset');
});
require __DIR__.'/auth.php';
