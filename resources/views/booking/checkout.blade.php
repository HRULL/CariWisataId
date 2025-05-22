<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Checkout Booking - CariWisataID</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
</head>

<body class="bg-light">

    <nav class="navbar navbar-light bg-white shadow-sm mb-4">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="{{ url('/dashboard') }}">CariWisataID</a>
            <a href="{{ url()->previous() }}" class="btn btn-outline-secondary">⬅ Kembali</a>
        </div>
    </nav>

    <div class="container">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Checkout Booking</h4>
            </div>
            <div class="card-body">
                @php
                $total = $booking->jumlah_tiket * ($booking->destination->harga ?? 0);
                @endphp

                <dl class="row mb-4">
                    <dt class="col-sm-4">Nama Destinasi</dt>
                    <dd class="col-sm-8">{{ $booking->destination->nama ?? '-' }}</dd>

                    <dt class="col-sm-4">Nama Pemesan</dt>
                    <dd class="col-sm-8">{{ $booking->nama_lengkap }}</dd>

                    <dt class="col-sm-4">Tanggal Booking</dt>
                    <dd class="col-sm-8">{{ \Carbon\Carbon::parse($booking->tanggal_booking)->format('d M Y') }}</dd>

                    <dt class="col-sm-4">Jumlah Tiket</dt>
                    <dd class="col-sm-8">{{ $booking->jumlah_tiket }}</dd>

                    <dt class="col-sm-4">Total Harga</dt>
                    <dd class="col-sm-8 fw-bold text-success">Rp {{ number_format($total, 0, ',', '.') }}</dd>
                </dl>

                <form id="checkoutForm">
                    @csrf
                    <div class="mb-3">
                        <label for="uang_bayar" class="form-label">Masukkan Uang Anda</label>
                        <input type="number" min="0" class="form-control" id="uang_bayar" required />
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Kembalian</label>
                        <input type="text" class="form-control" id="kembalian" readonly />
                    </div>

                    @if($booking->status === 'pending')
                    <button type="submit" class="btn btn-sm btn-success">Bayar Sekarang</button>
                    @else
                    <div class="alert alert-success">Status: <strong>Sukses</strong></div>
                    @endif

                    <a href="{{ url('/user') }}" class="btn btn-outline-secondary">Batal</a>
                </form>
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
                <div class="modal-body">
                    <p><strong>Terima kasih, {{ $booking->nama_lengkap }}!</strong></p>
                    <p>Booking destinasi <strong>{{ $booking->destination->nama }}</strong> berhasil.</p>
                    <p>Total: <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong></p>
                    <p>Uang dibayar: <span id="modalBayar"></span></p>
                    <p>Kembalian: <span id="modalKembalian"></span></p>
                </div>
                <div class="modal-footer">
                    <a href="{{ url('/user') }}" class="btn btn-primary">Kembali ke Dashboard</a>
                </div>
            </div>
        </div>
    </div>

    <footer class="text-center py-4 mt-5 text-muted">
        &copy; {{ date('Y') }} CariWisataID
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        const totalHarga = {{ $total }};
        const uangBayarInput = document.getElementById("uang_bayar");
        const kembalianInput = document.getElementById("kembalian");
        const form = document.getElementById("checkoutForm");

        uangBayarInput.addEventListener("input", function() {
            const uang = parseInt(this.value) || 0;
            const kembali = uang - totalHarga;

            kembalianInput.value = kembali >= 0 ? 'Rp ' + kembali.toLocaleString('id-ID') : 'Uang tidak cukup';
        });

        form.addEventListener("submit", async function(e) {
            e.preventDefault();

            const uang = parseInt(uangBayarInput.value);
            if (isNaN(uang) || uang < totalHarga) {
                alert("Uang kurang, gak bisa bayar 😢");
                return;
            }

            if (!confirm("Yakin mau bayar dan ubah status jadi sukses?")) return;

            const btn = form.querySelector("button[type=submit]");
            btn.disabled = true;
            btn.textContent = "Proses...";

            try {
                const response = await fetch("{{ url('/booking/update-status') }}/{{ $booking->id }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ uang_bayar: uang })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    btn.textContent = "Sudah Dibayar";
                    btn.disabled = true;

                    document.getElementById("modalBayar").innerText = 'Rp ' + data.uang_bayar.toLocaleString('id-ID');
                    document.getElementById("modalKembalian").innerText = 'Rp ' + data.kembalian.toLocaleString('id-ID');

                    const modal = new bootstrap.Modal(document.getElementById("buktiModal"));
                    modal.show();
                } else {
                    throw new Error(data.error || "Terjadi kesalahan");
                }
            } catch (error) {
                alert("Gagal bayar: " + error.message);
                btn.disabled = false;
                btn.textContent = "Bayar Sekarang";
            }
        });
    </script>
</body>

</html>
