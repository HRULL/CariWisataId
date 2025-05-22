@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Daftar Pengguna</h1>

    <div class="bg-white rounded-lg shadow overflow-x-auto">
        <table class="min-w-full border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border text-left">#</th>
                    <th class="px-4 py-2 border text-left">Nama</th>
                    <th class="px-4 py-2 border text-left">Email</th>
                    <th class="px-4 py-2 border text-left">Password (Hash)</th>
                    <th class="px-4 py-2 border text-left">Role</th>
                    <th class="px-4 py-2 border text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $index => $user)
                    <tr class="hover:bg-gray-50">
                        <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                        <td class="px-4 py-2 border">{{ $user->name }}</td>
                        <td class="px-4 py-2 border">{{ $user->email }}</td>
                        <td class="px-4 py-2 border text-xs break-all">{{ $user->password }}</td>
                        <td class="px-4 py-2 border capitalize">{{ $user->role }}</td>
                        <td class="px-4 py-2 border space-x-2">

                            <!-- Form ganti role -->
                            <form action="{{ route('admin.users.updateRole', $user->id) }}" method="POST" class="inline">
                                @csrf
                                @method('PATCH')
                                <select name="role" onchange="this.form.submit()" class="border rounded px-2 py-1 text-sm">
                                    <option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
                                    <option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
                                </select>
                            </form>

                            <!-- Form hapus user -->
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin mau hapus user ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:underline text-sm">Hapus</button>
                            </form>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center py-4">Belum ada data pengguna.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
