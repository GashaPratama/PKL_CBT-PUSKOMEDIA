<x-layouts.admin title="Manajemen Rombongan Belajar">

    <div class="max-w-4xl mx-auto bg-white p-6 sm:p-8 rounded-xl shadow">

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">👥 Rombongan Belajar</h2>
            <a href="{{ route('admin.dashboard') }}" class="text-sm bg-gray-200 hover:bg-gray-300 text-gray-800 px-3 py-1 rounded transition">
                ← Kembali ke Dashboard
            </a>
        </div>

        <!-- Notifikasi -->
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 border border-green-300 rounded text-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form Tambah -->
        <form method="POST" action="{{ route('admin.rombel.store') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            @csrf
            <select name="kelas_id" required class="border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500">
                <option value="" disabled selected>🔽 Pilih Kelas</option>
                @foreach($kelas as $k)
                    <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                @endforeach
            </select>
            <input type="text" name="nama_kelompok" class="border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Kelompok (cth: A)" required>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                ➕ Tambah
            </button>
        </form>

        <!-- Tabel -->
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-200 text-sm rounded-lg overflow-hidden">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="border px-3 py-2">#</th>
                        <th class="border px-3 py-2">Kelas</th>
                        <th class="border px-3 py-2">Kelompok</th>
                        <th class="border px-3 py-2 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rombels as $i => $r)
                        <tr class="hover:bg-gray-50">
                            <td class="border px-3 py-2">{{ $i + 1 }}</td>
                            <td class="border px-3 py-2">{{ $r->kelas->nama_kelas }}</td>
                            <td class="border px-3 py-2">{{ $r->nama_kelompok }}</td>
                            <td class="border px-3 py-2 text-center">
                                <form action="{{ route('admin.rombel.destroy', $r->id) }}" method="POST" onsubmit="return confirm('Yakin hapus rombel ini?');">
                                    @csrf @method('DELETE')
                                    <button class="text-red-600 hover:underline text-sm">🗑 Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-3 py-4 text-center text-gray-500">Belum ada rombel yang ditambahkan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</x-layouts.admin>
