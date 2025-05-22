<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Tambah Destinasi - CariWisataID</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-900 min-h-screen flex flex-col">

    <!-- Header -->
    <header class="bg-gray-900 shadow p-4 flex items-center justify-between">
        <div class="flex items-center space-x-3">
            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#ffffff" class="bi bi-bootstrap-fill" viewBox="0 0 16 16">
                <path d="M5.062 12.36c.839.55 1.887.693 3.098.693 1.388 0 2.343-.343 2.94-.866.587-.514.944-1.266.944-2.17 0-1.227-.868-2.14-2.123-2.364v-.095c1.09-.242 1.839-1.094 1.839-2.164 0-.804-.308-1.45-.838-1.895C9.943 3.12 8.996 2.9 7.753 2.9c-.924 0-1.838.064-2.691.18v9.28zm2.7-5.16H6.16V4.61h1.63c1.13 0 1.792.533 1.792 1.302 0 .818-.636 1.288-1.622 1.288zM6.16 7.87h1.788c1.22 0 1.937.57 1.937 1.45 0 .945-.735 1.455-1.92 1.455H6.16V7.87z"/>
            </svg>
            <span class="text-white text-xl font-semibold">Admin Panel</span>
        </div>

        <nav class="flex items-center space-x-6">
            <a href="{{ url('/dashboard') }}" class="text-white hover:text-blue-400 font-medium transition">Dashboard User</a>
            <a href="{{ route('logout') }}"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
               class="text-red-400 hover:text-red-600 font-medium transition">Logout</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
        </nav>
    </header>

    <!-- Body Wrapper -->
    <div class="flex flex-1">
        <!-- Sidebar -->
        <aside class="w-64 bg-white shadow-md p-6 space-y-6 flex flex-col">
            <div class="text-2xl font-bold text-center mb-8">CariWisataID</div>

            <nav class="flex flex-col space-y-2">
                <a href="{{ route('admin.dashboard') }}"
                    class="flex items-center gap-2 px-4 py-2 rounded hover:bg-gray-200 {{ request()->routeIs('dashboard') ? 'bg-blue-100 text-blue-700 font-semibold' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-house" viewBox="0 0 16 16">
                        <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z" />
                    </svg>
                    Dashboard
                </a>

                <a href="{{ route('destinasi.index') }}"
                    class="flex items-center gap-2 px-4 py-2 rounded hover:bg-gray-200 {{ request()->routeIs('destinasi.*') ? 'bg-blue-100 text-blue-700 font-semibold' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-map" viewBox="0 0 16 16">
                        <path d="M0 1.5A.5.5 0 0 1 .5 1l4.36 1.452L11.5 1a.5.5 0 0 1 .5.5v12a.5.5 0 0 1-.5.5l-4.36-1.452L.5 15a.5.5 0 0 1-.5-.5v-13zM5 2.658v10.684l6 2V4.658l-6-2z" />
                    </svg>
                    Destinasi
                </a>

                <a href="{{ route('admin.users') }}"
                    class="flex items-center gap-2 px-4 py-2 rounded hover:bg-gray-200 {{ request()->routeIs('admin.users') ? 'bg-blue-100 text-blue-700 font-semibold' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people" viewBox="0 0 16 16">
                        <path d="M13 7a2 2 0 1 0-4 0 2 2 0 0 0 4 0zM9 7a2 2 0 1 1-4 0 2 2 0 0 1 4 0z" />
                        <path fill-rule="evenodd" d="M13 14s-1 0-1-1 1-4 4-4 4 3 4 4-1 1-1 1h-6zm-6 0s-1 0-1-1 1-4 4-4 4 3 4 4-1 1-1 1H7z" />
                    </svg>
                    Total Users
                </a>

                <a href="{{ route('admin.booking') }}"
                    class="flex items-center gap-2 px-4 py-2 rounded hover:bg-gray-200 {{ request()->routeIs('admin.bookings') ? 'bg-blue-100 text-blue-700 font-semibold' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-calendar-check" viewBox="0 0 16 16">
                        <path d="M10.854 6.646a.5.5 0 0 0-.708.708L11.293 9l-1.647 1.646a.5.5 0 0 0 .708.708l2-2a.5.5 0 0 0 0-.708l-2-2z" />
                        <path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h1A.5.5 0 0 1 4 1.5v.5h8v-.5a.5.5 0 0 1 .5-.5h1A1.5 1.5 0 0 1 15 2.5V14a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2.5zM2.5 2a.5.5 0 0 0-.5.5V3h12v-.5a.5.5 0 0 0-.5-.5h-1v.5a.5.5 0 0 1-1 0V2h-8v.5a.5.5 0 0 1-1 0V2h-1z" />
                    </svg>
                    Booking
                </a>
            </nav>

            
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8 overflow-auto">
            <h1 class="text-3xl font-bold mb-6">Tambah Destinasi</h1>

            <form action="{{ route('destinasi.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-6 rounded shadow-md max-w-xl">
                @csrf
                <div class="mb-4">
                    <label for="nama" class="block text-sm font-medium mb-1">Nama</label>
                    <input type="text" name="nama" id="nama" class="w-full border p-2 rounded" required>
                </div>
                <div class="mb-4">
                    <label for="lokasi" class="block text-sm font-medium mb-1">Lokasi</label>
                    <input type="text" name="lokasi" id="lokasi" class="w-full border p-2 rounded" required>
                </div>
                <div class="mb-4">
                    <label for="harga" class="block text-sm font-medium mb-1">Harga</label>
                    <input type="number" name="harga" id="harga" class="w-full border p-2 rounded" required>
                </div>

                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium mb-1">Upload Gambar</label>
                    <input type="file" name="image" id="image" accept="image/*" class="w-full border p-2 rounded">
                </div>

                <div class="flex justify-between items-center">
                    <a href="{{ route('destinasi.index') }}" class="text-gray-600 hover:underline">← Kembali</a>
                    <button type="submit" class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700">Simpan</button>
                </div>
            </form>
        </main>
    </div>
</body>

</html>
