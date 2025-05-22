<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\BookingController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', fn() => view('auth/login'));

Route::middleware('auth')->group(function () {

    // Redirect user setelah login sesuai role
    Route::get('/redirect', function () {
        $user = Auth::user();

        return match ($user->role) {
            'admin' => redirect()->route('admin.dashboard'),
            'user' => redirect()->route('user.index'),
            default => redirect('/login')->with('error', 'Role tidak dikenali.'),
        };
    })->name('redirect');

    // Dashboard umum untuk admin & user (bisa dikembangkan)
    Route::get('/dashboard', function () {
        $role = Auth::user()->role;
        if (in_array($role, ['admin', 'user'])) {
            return view('dashboard');
        }
        abort(403, 'Akses ditolak!');
    })->name('dashboard');

    // Route user (akses buat user dan admin)
    Route::get('/tampilan', [DestinationController::class, 'userIndex'])->name('user.index');

    Route::get('/user/detail/{id}', [BookingController::class, 'showDetail'])->name('booking.detail');


    Route::get('/user', [BookingController::class, 'indexUser'])->middleware('auth')->name('user.index');


    // Profile
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');

    // Group route admin dengan prefix 'admin'
   Route::middleware('auth')->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak Bukan admin.');
        }
        return app(\App\Http\Controllers\AdminController::class)->index();
    })->name('admin.dashboard');

    Route::get('/users', function () {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak Bukan admin.');
        }
        return app(\App\Http\Controllers\AdminController::class)->listUsers();
    })->name('admin.users');

    Route::patch('/users/{user}/role', function ($user) {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak Bukan admin.');
        }
        return app(\App\Http\Controllers\AdminController::class)->updateUserRole($user);
    })->name('admin.users.updateRole');

    Route::delete('/users/{user}', function ($user) {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak Bukan admin.');
        }
        return app(\App\Http\Controllers\AdminController::class)->destroyUser($user);
    })->name('admin.users.destroy');

    Route::get('/booking', function () {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses ditolak Bukan admin.');
        }
        return app(\App\Http\Controllers\BookingController::class)->index();
    })->name('admin.booking');

    // Kalau kamu pakai Resource, batasi juga di controller-nya (lihat di bawah)
    Route::resource('/destinasi', DestinationController::class)->names([
        'index' => 'destinasi.index',
        'create' => 'destinasi.create',
        'store' => 'destinasi.store',
        'edit' => 'destinasi.edit',
        'update' => 'destinasi.update',
        'destroy' => 'destinasi.destroy',
    ]);

    Route::patch('/booking/{booking}/status', [BookingController::class, 'updateStatus'])->name('admin.booking.updateStatus');

});

});



Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [BookingController::class, 'dasindex'])->name('dashboard');
});



Route::middleware('auth')->group(function () {
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
});



Route::get('/user/checkout/{id}', [BookingController::class, 'checkout'])->name('booking.checkout');

Route::post('/booking/update-status/{id}', [BookingController::class, 'updateStatus'])->name('booking.updateStatus');





Route::post('/booking/pay/{id}', [BookingController::class, 'pay'])->name('booking.pay');


require __DIR__.'/auth.php';
