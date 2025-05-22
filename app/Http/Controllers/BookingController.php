<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Destination;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    // Tampilkan form booking
    
    // Simpan booking ke database
    public function store(Request $request)
    {
        $request->validate([
            'destination_id' => 'required|exists:destinations,id',
            'jumlah_tiket' => 'required|integer|min:1',
            'tanggal_booking' => 'required|date',
        ]);

        Booking::create([
            'user_id' => Auth::id(),
            'destination_id' => $request->destination_id,
            'nama_lengkap' => Auth::user()->name,
            'email' => Auth::user()->email,
            'jumlah_tiket' => $request->jumlah_tiket,
            'tanggal_booking' => $request->tanggal_booking,
        ]);

        return redirect()->route('user.index')->with('success', 'Booking berhasil dibuat!');
    }

    public function index()
{
    // Ambil semua booking, bisa juga pake pagination
    $bookings = \App\Models\Booking::with('destination', 'user')->latest()->paginate(10);

    return view('admin.booking', compact('bookings'));
}

//public function updateStatus($id)
//{
  /*  $booking = Booking::findOrFail($id);

    // Toggle status
    $booking->status = $booking->status === 'pending' ? 'sukses' : 'pending';
    $booking->save();

    return redirect()->route('admin.booking')->with('success', 'Status booking berhasil diperbarui.');
}*/

// Controller userIndex di DestinationController



public function indexUser()
{
    $destinations = Destination::paginate(9);

    $bookings = auth()->user()->bookings()->with('destination')->orderBy('created_at', 'desc')->get();

    return view('user.index', compact('destinations', 'bookings'));
    
}

public function dasindex()
{
    // Ambil data booking user yang sedang login, misal user id dari auth
    $bookings = auth()->user()->bookings()->with('destination')->latest()->get();

    // Kirim ke view dashboard
    return view('dashboard', compact('bookings'));
}

public function showDetail($id)
{
    $booking = Booking::with('destination')->findOrFail($id);

    // Cek apakah booking milik user yang login
    if ($booking->user_id !== auth()->id()) {
        abort(403, 'Akses ditolak.');
    }

    return view('user.detail', compact('booking'));
}



public function checkout($id)
    {
        $booking = Booking::with('destination')->findOrFail($id);

        if ($booking->user_id !== auth()->id()) {
            abort(403, 'Akses ditolak');
        }

        return view('booking.checkout', compact('booking'));
    }

    // Update status booking setelah bayar
    public function updateStatus(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);

        if ($booking->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $totalHarga = $booking->jumlah_tiket * $booking->destination->harga;

        $uangBayar = (int) $request->input('uang_bayar');

        if ($uangBayar < $totalHarga) {
            return response()->json(['error' => 'Uang kurang, gak bisa bayar 😢'], 400);
        }

        $booking->status = 'sukses';
        $booking->save();

        $kembalian = $uangBayar - $totalHarga;

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran berhasil! Status booking jadi sukses.',
            'uang_bayar' => $uangBayar,
            'kembalian' => $kembalian
        ]);
    }
}

