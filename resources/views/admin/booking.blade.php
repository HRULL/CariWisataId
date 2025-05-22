@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Data Booking</h1>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border text-left">#</th>
                    <th class="px-4 py-2 border text-left">Nama Pemesan</th>
                    <th class="px-4 py-2 border text-left">Email</th>
                    <th class="px-4 py-2 border text-left">Destinasi</th>
                    <th class="px-4 py-2 border text-left">Jumlah Tiket</th>
                    <th class="px-4 py-2 border text-left">Tanggal Booking</th>
                    <th class="px-4 py-2 border text-left">Total Bayar</th> <!-- ✅ -->
                    <th class="px-4 py-2 border text-left">Status</th>
                    <th class="px-4 py-2 border text-left">Aksi</th>
                    <th class="px-4 py-2 border text-left">Dibuat Pada</th>
                </tr>
            </thead>
            <tbody>
                @forelse($bookings as $index => $booking)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                    <td class="px-4 py-2 border">{{ $booking->nama_lengkap }}</td>
                    <td class="px-4 py-2 border">{{ $booking->email }}</td>
                    <td class="px-4 py-2 border">{{ $booking->destination->nama ?? '-' }}</td>
                    <td class="px-4 py-2 border">{{ $booking->jumlah_tiket }}</td>
                    <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d-m-Y') }}</td>
                    
                    <!-- ✅ TOTAL PEMBAYARAN -->
                    <td class="px-4 py-2 border">
                        @if($booking->destination)
                            Rp {{ number_format($booking->jumlah_tiket * $booking->destination->harga, 0, ',', '.') }}
                        @else
                            -
                        @endif
                    </td>

                    <td class="px-4 py-2 border">
                        @if($booking->status === 'pending')
                            <span class="bg-yellow-100 text-yellow-800 text-sm px-2 py-1 rounded-full">Pending</span>
                        @elseif($booking->status === 'sukses')
                            <span class="bg-green-100 text-green-800 text-sm px-2 py-1 rounded-full">Sukses</span>
                        @endif
                    </td>
                    <td class="px-4 py-2 border">
                        <form action="{{ route('admin.booking.updateStatus', $booking->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="text-sm text-blue-600 hover:underline">
                                @if($booking->status === 'pending')
                                    Tandai Sukses
                                @else
                                    Tandai Pending
                                @endif
                            </button>
                        </form>
                    </td>
                    <td class="px-4 py-2 border">{{ $booking->created_at->format('d-m-Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="10" class="text-center py-4">Belum ada data booking.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $bookings->links() }}
    </div>
</div>
@endsection
