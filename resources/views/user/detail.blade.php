<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Detail Booking - CariWisataID</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body class="bg-light">

    <!-- Navbar -->
    <nav class="navbar navbar-light bg-white shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="{{ url('/dashboard') }}">CariWisataID</a>
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">⬅ Kembali</a>
        </div>
    </nav>

    <!-- Konten -->
    <div class="container">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Detail Booking</h4>
            </div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-sm-4">Nama Destinasi</dt>
                    <dd class="col-sm-8">{{ $booking->destination->nama ?? '-' }}</dd>

                    <dt class="col-sm-4">Lokasi</dt>
                    <dd class="col-sm-8">{{ $booking->destination->lokasi ?? '-' }}</dd>

                    <dt class="col-sm-4">Harga per Tiket</dt>
                    <dd class="col-sm-8">Rp {{ number_format($booking->destination->harga ?? 0, 0, ',', '.') }}</dd>

                    <dt class="col-sm-4">Jumlah Tiket</dt>
                    <dd class="col-sm-8">{{ $booking->jumlah_tiket }}</dd>

                    <dt class="col-sm-4">Total Bayar</dt>
                    <dd class="col-sm-8 fw-bold text-success">
                        Rp {{ number_format(($booking->jumlah_tiket ?? 0) * ($booking->destination->harga ?? 0), 0, ',', '.') }}
                    </dd>

                    <dt class="col-sm-4">Tanggal Booking</dt>
                    <dd class="col-sm-8">{{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}</dd>

                    <dt class="col-sm-4">Status</dt>
                    <dd class="col-sm-8">
                        @if($booking->status === 'pending')
                        <span class="badge bg-warning text-dark">Pending</span>
                        @elseif($booking->status === 'sukses')
                        <span class="badge bg-success">Sukses</span>
                        @else
                        <span class="badge bg-secondary">-</span>
                        @endif
                    </dd>
                </dl>

                {{-- Tombol lihat bukti pembayaran --}}
                @if($booking->status === 'sukses')
                <button type="button" class="btn btn-success mt-3" data-bs-toggle="modal" data-bs-target="#buktiModal">
                    Lihat Bukti Pembayaran
                </button>
                @endif

            </div>
        </div>
    </div>

    <!-- Modal Bukti Pembayaran -->
    <div class="modal fade" id="buktiModal" tabindex="-1" aria-labelledby="buktiModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content shadow">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title" id="buktiModalLabel">Bukti Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>
                <div class="modal-body text-center">
                    <p><strong>Terima kasih, {{ $booking->nama_lengkap }}!</strong></p>
                    <p>Booking destinasi <strong>{{ $booking->destination->nama }}</strong> berhasil.</p>
                    <p>Total Bayar: <strong>Rp {{ number_format($booking->jumlah_tiket * ($booking->destination->harga ?? 0), 0, ',', '.') }}</strong></p>
                    <p>Uang Dibayar: <strong>Rp {{ number_format($booking->uang_dibayar ?? 0, 0, ',', '.') }}</strong></p>
                    <p>Kembalian: <strong>Rp {{ number_format(($booking->uang_dibayar ?? 0) - ($booking->jumlah_tiket * ($booking->destination->harga ?? 0)), 0, ',', '.') }}</strong></p>

                    @if($booking->bukti_pembayaran)
                    <img src="{{ asset('storage/bukti/' . $booking->bukti_pembayaran) }}" alt="Bukti Pembayaran" class="img-fluid mt-3 rounded shadow" />
                    @else
                    <p class="text-muted">Belum ada bukti pembayaran yang diunggah.</p>
                    @endif
                </div>
                <div class="modal-footer">
                    <a href="{{ url('/user') }}" class="btn btn-primary">Kembali ke Dashboard</a>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="text-center py-4 mt-5 text-muted">
        &copy; {{ date('Y') }} CariWisataID
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>