<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-white text-3xl text-gray-900 leading-tight">
            {{ __('Selamat Datang, ') . auth()->user()->name . '!' }}
        </h2>
    </x-slot>

    <main class="py-10 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Hero Section -->
            <section class="relative bg-cover bg-center h-64 rounded-lg mb-8" style="background-image: url('https://www.mypangandaran.com/gambar/blog/blog-7-objek-wisata-pantai-di-kabupaten-pangandaran-372-l.jpg');">
                <div class="absolute inset-0 bg-black opacity-50 rounded-lg"></div>
                <div class="relative flex items-center justify-center h-full">
                    <h1 class="text-white text-4xl font-bold">Temukan Destinasi Impianmu</h1>
                </div>
            </section>

            <!-- Card info -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Profil Kamu</h3>
                    <p class="text-gray-700">Nama: <span class="font-semibold">{{ auth()->user()->name }}</span></p>
                    <p class="text-gray-700">Email: <span class="font-semibold">{{ auth()->user()->email }}</span></p>
                    <p class="text-gray-700">Role: <span class="font-semibold capitalize">{{ auth()->user()->role }}</span></p>
                </div>

                <div class="bg-white shadow rounded-lg p-6">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Status Login</h3>
                    <p class="text-gray-700">{{ __("You're logged in!") }}</p>
                    <p class="mt-2 text-sm text-gray-500">Terakhir login: {{ auth()->user()->last_login_at ?? 'Belum pernah login sebelumnya' }}</p>
                </div>

                <div class="bg-white shadow rounded-lg p-6 flex flex-col justify-center items-center">
                    <h3 class="text-lg font-medium text-gray-900 mb-2">Mulai Jelajah</h3>
                    <a href="{{ route(auth()->user()->role === 'admin' ? 'admin.dashboard' : 'user.index') }}" 
                       class="inline-block px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-md font-semibold transition">
                        {{ auth()->user()->role === 'admin' ? 'Ke Admin Dashboard' : 'Lihat Destinasi' }}
                    </a>
                </div>
            </div>

            


<!-- Modal Riwayat Booking (slide-in dari kanan) -->
<div id="modalRiwayat" class="fixed top-0 right-0 h-full w-80 bg-white shadow-lg transform translate-x-full transition-transform duration-300 ease-in-out overflow-auto z-50">
    <div class="p-4 flex justify-between items-center border-b bg-dark">
        <h2 class="text-lg font-semibold bg-primary">Riwayat Booking</h2>
        <button onclick="toggleModal(false)" class="text-xl font-bold">&times;</button>
    </div>
    <div class="p-4">
        @if($bookings->isEmpty())
            <p class="text-gray-500">Belum ada riwayat booking.</p>
        @else
            @foreach($bookings as $booking)
                <div class="border-b py-2 mb-3">
                    <strong>{{ $booking->destination->nama ?? '-' }}</strong><br>
                    Tanggal: {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}<br>
                    Jumlah Tiket: {{ $booking->jumlah_tiket }}<br>
                    Total Bayar: Rp {{ number_format(($booking->jumlah_tiket * ($booking->destination->harga ?? 0)), 0, ',', '.') }}<br>
                    Status: 
                    @if($booking->status === 'pending')
                        <span class="text-yellow-500 font-semibold">Pending</span>
                    @elseif($booking->status === 'sukses')
                        <span class="text-green-600 font-semibold">Sukses</span>
                    @else
                        <span>-</span>
                    @endif

                    <!-- Tombol Detail -->
                    <a href="{{ route('booking.detail', $booking->id) }}" 
                       class="inline-block mt-2 px-3 py-1 text-sm text-white bg-blue-600 rounded hover:bg-blue-700">
                        Detail
                    </a>
                </div>
            @endforeach
        @endif
    </div>
</div>


<script>
function toggleModal(show) {
    const modal = document.getElementById('modalRiwayat');
    const btn = document.getElementById('btnRiwayat');
    if (show) {
        modal.classList.remove('translate-x-full');
        btn.classList.add('bg-gray-300', 'text-black'); // kasih bg-gray saat active
    } else {
        modal.classList.add('translate-x-full');
        btn.classList.remove('bg-gray-300', 'text-black'); // hapus bg-gray pas modal tutup
    }
}

</script>


            <!-- Informasi tambahan / banner -->
            <section class="bg-white rounded-lg shadow p-6">
                <h3 class="text-xl font-semibold text-gray-900 mb-4">Info Terbaru</h3>
                <p class="text-gray-700 leading-relaxed">
                    Selamat datang di CariWisataID! Temukan destinasi wisata terbaik dan rekomendasi menarik khusus untuk kamu. 
                    Jangan lupa cek halaman destinasi untuk update terbaru.
                </p>
            </section>

        </div>
    </main>
</x-app-layout>