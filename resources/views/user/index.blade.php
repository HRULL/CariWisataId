<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Destinasi Wisata - CariWisataID</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <style>
        /* ✨ Animasi modal slide dari kiri */
        .modal-dialog-slideout {
            position: fixed;
            top: 0;
            right: 0;
            margin: 0;
            height: 100vh;
            max-width: 350px;
            /* Lebar modal ditingkatkan */
            width: 100%;
            transform: translateX(100%);
            transition: transform 0.3s ease-out;
            z-index: 1050;
        }

        .modal.fade.show .modal-dialog-slideout {
            transform: translateX(0);
        }

        .modal-dialog-slideout .modal-content {
            height: 100%;
            border-radius: 0;
            overflow-y: auto;
        }
    </style>
</head>

<body class="bg-light">

    <!-- ✅ Header -->
    <nav class="navbar navbar-light bg-white shadow-sm mb-4">
        <div class="container d-flex justify-content-between align-items-center">
            <a class="navbar-brand fw-bold text-primary" href="{{ url('/dashboard') }}">CariWisataID</a>

            <!-- ✅ Tombol Riwayat -->
            <button class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#bookingHistoryModal">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-cart-dash" viewBox="0 0 16 16">
                    <path d="M6.5 7a.5.5 0 0 0 0 1h4a.5.5 0 0 0 0-1z" />
                    <path d="M.5 1a.5.5 0 0 0 0 1h1.11l.401 1.607 1.498 7.985A.5.5 0 0 0 4 12h1a2 2 0 1 0 0 4 2 2 0 0 0 0-4h7a2 2 0 1 0 0 4 2 2 0 0 0 0-4h1a.5.5 0 0 0 .491-.408l1.5-8A.5.5 0 0 0 14.5 3H2.89l-.405-1.621A.5.5 0 0 0 2 1zm3.915 10L3.102 4h10.796l-1.313 7zM6 14a1 1 0 1 1-2 0 1 1 0 0 1 2 0m7 0a1 1 0 1 1-2 0 1 1 0 0 1 2 0" />
                </svg>
                Keranjang
            </button>


        </div>
    </nav>

    <!-- Modal Riwayat Booking -->
    <div class="modal fade" id="bookingHistoryModal" tabindex="-1" aria-labelledby="bookingHistoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideout">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="bookingHistoryModalLabel">Keranjang</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body overflow-auto" style="max-height: 70vh;">
                @php
                    $pendingBookings = $bookings->where('status', 'pending');
                @endphp

                @if($pendingBookings->isEmpty())
                <p class="text-muted text-center">😢 Belum ada booking yang statusnya pending.</p>
                @else
                @foreach($pendingBookings as $booking)
                <div class="card mb-3 shadow-sm border-0">
                    <div class="card-body">
                        <h5 class="card-title fw-bold mb-1">{{ $booking->destination->nama ?? '-' }}</h5>
                        <p class="mb-1">
                            <i class="bi bi-calendar-event"></i>
                            <strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}
                        </p>
                        <p class="mb-1">
                            <i class="bi bi-ticket-detailed"></i>
                            <strong>Jumlah Tiket:</strong> {{ $booking->jumlah_tiket }}
                        </p>
                        <p class="mb-2">
                            <i class="bi bi-info-circle"></i>
                            <strong>Status:</strong>
                            <span class="badge bg-warning text-dark">Pending</span>
                        </p>
                        <a href="{{ route('booking.detail', $booking->id) }}" class="btn btn-sm btn-outline-primary">Lihat Detail</a>

                        <a href="{{ route('booking.checkout', $booking->id) }}" class="btn btn-sm btn-success ms-2">Checkout</a>
                    </div>
                </div>
                @endforeach
                @endif
            </div>

            <!-- Footer modal kalau perlu -->
        </div>
    </div>
</div>




    <!-- ✅ Konten Destinasi -->
    <div class="container">

        @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Tutup"></button>
        </div>
        @endif

        <div class="row g-4">
            @forelse ($destinations as $dest)
            <div class="col-12 col-sm-6 col-md-4">
                <div class="card h-100 shadow-sm">
                    @if ($dest->image)
                    <img src="{{ asset('storage/destinasi/'. $dest->image) }}" class="card-img-top" alt="{{ $dest->nama }}" />
                    @else
                    <div class="bg-secondary text-white d-flex justify-content-center align-items-center" style="height: 200px;">
                        <span>Tidak ada gambar</span>
                    </div>
                    @endif
                    <div class="card-body">
                        <h5 class="card-title">{{ $dest->nama }}</h5>
                        <p class="card-text text-muted">{{ $dest->lokasi }}</p>
                        <p class="card-text fw-bold text-primary">Rp {{ number_format($dest->harga, 0, ',', '.') }}</p>

                        <button type="button" class="btn btn-primary mt-2" data-bs-toggle="modal" data-bs-target="#bookingModal{{ $dest->id }}">
                            Booking
                        </button>
                    </div>
                </div>
            </div>

            <!-- Modal Booking -->
            <div class="modal fade" id="bookingModal{{ $dest->id }}" tabindex="-1" aria-labelledby="bookingModalLabel{{ $dest->id }}" aria-hidden="true">
                <div class="modal-dialog">
                    <form action="{{ route('booking.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="destination_id" value="{{ $dest->id }}" />
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Booking: {{ $dest->nama }}</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label>Nama Lengkap</label>
                                    <input type="text" name="nama_lengkap" class="form-control" value="{{ auth()->user()->name }}" readonly />
                                </div>
                                <div class="mb-3">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ auth()->user()->email }}" readonly />
                                </div>
                                <div class="mb-3">
                                    <label>Jumlah Tiket</label>
                                    <input type="number" name="jumlah_tiket" class="form-control" min="1" required />
                                </div>
                                <div class="mb-3">
                                    <label>Tanggal Booking</label>
                                    <input type="date" name="tanggal_booking" class="form-control" required />
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Pesan Sekarang</button>
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <p class="text-muted">Belum ada destinasi yang tersedia.</p>
            </div>
            @endforelse
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center py-4 mt-5 text-muted">
        &copy; {{ date('Y') }} CariWisataID
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>