@extends('layouts.admin')

@section('content')
    <h1 class="text-3xl font-bold mb-6">Dashboard Admin</h1>

    <!-- Kartu Statistik -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <p class="text-gray-500">Total Users</p>
            <p class="text-3xl font-bold">{{ $totalUsers }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <p class="text-gray-500">Total Destinasi</p>
            <p class="text-3xl font-bold">{{ $totalDestinasi }}</p>
        </div>
        <div class="bg-white p-6 rounded-lg shadow text-center">
            <p class="text-gray-500">Total Booking</p>
            <p class="text-3xl font-bold">{{ $totalBooking }}</p>
        </div>
    </div>

    <!-- Tabel Destinasi Terbaru -->
    <h2 class="text-xl font-semibold mb-4">Destinasi Terbaru</h2>
    <div class="bg-white p-6 rounded-lg shadow overflow-x-auto">
        <table class="min-w-full table-auto border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">#</th>
                    <th class="px-4 py-2 border">Nama</th>
                    <th class="px-4 py-2 border">Lokasi</th>
                    <th class="px-4 py-2 border">Harga</th>
                    <th class="px-4 py-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($destinations as $dest)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border">{{ $loop->iteration }}</td>
                    <td class="px-4 py-2 border">{{ $dest->nama }}</td>
                    <td class="px-4 py-2 border">{{ $dest->lokasi }}</td>
                    <td class="px-4 py-2 border">Rp {{ number_format($dest->harga) }}</td>
                    <td class="px-4 py-2 border">
                        <a href="{{ route('destinasi.edit', $dest->id) }}" class="text-blue-600 hover:underline">Edit</a>
                        <form action="{{ route('destinasi.destroy', $dest->id) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Yakin ingin menghapus?')" class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
