<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Peserta</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-4 sm:p-6">

    <div class="max-w-6xl mx-auto bg-white shadow-md rounded-xl p-6 sm:p-8">

        <!-- Header dan Aksi -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-3">
            <h2 class="text-2xl font-bold">Daftar Peserta</h2>
            <div class="space-x-2">
                <a href="{{ route('admin.user.export.excel') }}"
                   class="bg-green-600 text-white px-3 py-1 rounded hover:bg-green-700 text-sm">
                    📥 Export Excel
                </a>
                <a href="{{ route('admin.user.export.pdf') }}"
                   class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-sm">
                    📄 Export PDF
                </a>
            </div>
        </div>

        <!-- Filter Kelas dan Kelompok -->
        <form method="GET" action="{{ route('admin.user.show') }}" class="mb-4 flex flex-wrap gap-3 items-end">
            <div>
                <label class="block text-sm font-medium">Kelas</label>
                <input type="text" name="kelas" value="{{ request('kelas') }}"
                       class="border rounded px-2 py-1 text-sm w-40" placeholder="Contoh: 10">
            </div>
            <div>
                <label class="block text-sm font-medium">Kelompok</label>
                <input type="text" name="kelompok" value="{{ request('kelompok') }}"
                       class="border rounded px-2 py-1 text-sm w-40" placeholder="Contoh: A">
            </div>
            <button type="submit"
                    class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 text-sm mt-1 sm:mt-0">
                🔍 Filter
            </button>
            <a href="{{ route('admin.user.show') }}"
               class="text-gray-600 hover:underline text-sm mt-1 sm:mt-0">🔄 Reset</a>
        </form>

        <!-- Notifikasi sukses -->
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded text-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tabel Responsif -->
        <div class="overflow-x-auto">
            <table class="min-w-full border text-left text-sm sm:text-base">
                <thead class="bg-gray-200">
                    <tr>
                        <th class="p-2 border">#</th>
                        <th class="p-2 border">Nama Lengkap</th>
                        <th class="p-2 border">Email</th>
                        <th class="p-2 border">No Telpon</th>
                        <th class="p-2 border">Jenis Kelamin</th>
                        <th class="p-2 border">Kelas</th>
                        <th class="p-2 border">Kelompok</th>
                        <th class="p-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="p-2">{{ $index + 1 }}</td>
                            <td class="p-2">{{ $user->nama_lengkap }}</td>
                            <td class="p-2">{{ $user->email }}</td>
                            <td class="p-2">{{ $user->no_telpon }}</td>
                            <td class="p-2">{{ $user->jenis_kelamin }}</td>
                            <td class="p-2">{{ $user->kelas ?? '-' }}</td>
                            <td class="p-2">{{ $user->kelompok ?? '-' }}</td>
                            <td class="p-2 space-y-1 sm:space-y-0 sm:space-x-2 flex flex-col sm:flex-row">
                                <form action="{{ route('admin.user.reset', $user->id_user) }}" method="POST" class="inline">
                                    @csrf
                                    <button type="submit"
                                            onclick="return confirm('Reset password untuk {{ $user->nama_lengkap }} ke default?')"
                                            class="text-blue-600 hover:underline text-sm">
                                        🔁 Reset
                                    </button>
                                </form>

                                <a href="{{ route('admin.user.edit', $user->id_user) }}"
                                   class="text-yellow-600 hover:underline text-sm">
                                    ✏️ Edit
                                </a>

                                <form action="{{ route('admin.user.destroy', $user->id_user) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            onclick="return confirm('Yakin ingin menghapus {{ $user->nama_lengkap }}?')"
                                            class="text-red-600 hover:underline text-sm">
                                        🗑 Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="8" class="p-3 text-center text-gray-500">Tidak ada data peserta.</td></tr>
                    @endforelse
                </tbody>
            </table>

            <a href="{{ route('admin.dashboard') }}"
               class="text-sm text-gray-600 hover:underline mt-4 inline-block">
                ← Kembali
            </a>
        </div>
    </div>

</body>
</html>
