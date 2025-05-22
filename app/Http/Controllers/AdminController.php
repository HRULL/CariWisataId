<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Destination;
use App\Models\Booking;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses hanya untuk admin!');
        }

        return view('admin.dashboard', [
            'totalUsers' => User::count(),
            'totalDestinasi' => Destination::count(),
            'totalBooking' => Booking::count(),
            'destinations' => Destination::latest()->take(5)->get(),
        ]);
    }

    public function listUsers()
    {
        $users = User::all();
        return view('admin.penggunadanbooking.pengguna', compact('users'));
    }

    public function updateUserRole(User $user)
    {
        if (auth()->id() == $user->id) {
            return redirect()->back()->with('error', 'Kamu gak bisa ganti role diri sendiri!');
        }

        $requestRole = request('role');
        if (in_array($requestRole, ['admin', 'user'])) {
            $user->role = $requestRole;
            $user->save();
            return redirect()->back()->with('success', 'Role berhasil diubah!');
        }

        return redirect()->back()->with('error', 'Role tidak valid.');
    }

    public function destroyUser(User $user)
    {
        if (auth()->id() == $user->id) {
            return redirect()->back()->with('error', 'Kamu gak bisa hapus diri sendiri!');
        }

        $user->delete();
        return redirect()->back()->with('success', 'User berhasil dihapus!');
    }

    // Method buat nampilin booking di admin
    public function bookings()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses hanya untuk admin!');
        }

        $bookings = Booking::with('destination')->latest()->paginate(10);

        return view('admin.booking', compact('bookings'));
    }
}
