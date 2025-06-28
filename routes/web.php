<?php

use App\Http\Controllers\CourseBookingController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['auth'])->group(function () {
    Route::resource('courses', CourseController::class);
    Route::put('courses/{course}/batch-action', [CourseController::class, 'batchAction'])->name('courses.batch-action');
    Route::resource('course-bookings', CourseBookingController::class);
    Route::put('course-bookings/{courseBooking}/approve', [CourseBookingController::class, 'approve'])->name('course-bookings.approve');
    Route::put('course-bookings/{courseBooking}/reject', [CourseBookingController::class, 'reject'])->name('course-bookings.reject');
    Route::resource('users', UserController::class);
    Route::get('profile', [UserController::class, 'profile'])->name('profile');
    Route::put('profile', [UserController::class, 'updateProfile'])->name('profile.update');
});