<?php

namespace App\Http\Controllers;

use App\Models\Destination;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DestinationController extends Controller
{
    // Untuk halaman yang bisa diakses user & admin
    public function userIndex()
    {
        $user = Auth::user();

        if (!in_array($user->role, ['user', 'admin'])) {
            abort(403, 'Akses hanya untuk user dan admin!');
        }

        $destinations = Destination::all();
        return view('user.index', compact('destinations'));
    }

    // Dashboard admin dan resource destinasi khusus admin
    public function adminDashboard()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses hanya untuk admin!');
        }

        return view('admin.dashboard');
    }

    public function index()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses hanya untuk admin!');
        }

        $destinations = Destination::all();
        return view('admin.destinasi.index', compact('destinations'));
    }

    public function create()
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses hanya untuk admin!');
        }

        return view('admin.destinasi.create');
    }

    public function store(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses hanya untuk admin!');
        }

        $request->validate([
            'nama' => 'required',
            'lokasi' => 'required',
            'harga' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $input = $request->all();

        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $nama = 'destinasi-' . now()->format('YmdHis') . '.' . $file->getClientOriginalExtension();
            $file->storeAs('public/destinasi', $nama);
            $input['image'] = $nama;
        }

        Destination::create($input);

        return redirect()->route('destinasi.index')->with('success', 'Destinasi berhasil ditambahkan!');
    }

    public function edit($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses hanya untuk admin!');
        }

        $destinasi = Destination::findOrFail($id);
        return view('admin.destinasi.edit', compact('destinasi'));
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses hanya untuk admin!');
        }

        $request->validate([
            'nama' => 'required',
            'lokasi' => 'required',
            'harga' => 'required|numeric',
        ]);

        Destination::findOrFail($id)->update($request->all());

        return redirect()->route('destinasi.index')->with('success', 'Berhasil update destinasi!');
    }

    public function destroy($id)
    {
        if (Auth::user()->role !== 'admin') {
            abort(403, 'Akses hanya untuk admin!');
        }

        Destination::destroy($id);

        return redirect()->route('destinasi.index')->with('success', 'Berhasil hapus destinasi!');
    }
}
