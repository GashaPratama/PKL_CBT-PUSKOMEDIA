<x-layouts.admin title="Manajemen Kelas">

    <div class="max-w-3xl mx-auto bg-white p-6 sm:p-8 rounded-xl shadow">

        <!-- Header -->
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">🏫 Manajemen Kelas</h2>
            <a href="{{ route('admin.dashboard') }}"
               class="text-sm bg-gray-200 hover:bg-gray-300 text-gray-800 px-3 py-1 rounded transition">
                ← Kembali ke Dashboard
            </a>
        </div>

        <!-- Notifikasi Sukses -->
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded text-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Form Tambah -->
        <form method="POST" action="{{ route('admin.kelas.store') }}" class="flex flex-col sm:flex-row gap-3 mb-6">
            @csrf
            <input type="text" name="nama_kelas" class="w-full border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Nama kelas (cth: 10)" required>
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition">
                ➕ Tambah
            </button>
        </form>

        <!-- Tabel Kelas -->
        <div class="overflow-x-auto">
            <table class="w-full table-auto text-sm text-left border border-gray-200 rounded-lg overflow-hidden">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="px-3 py-2 border">#</th>
                        <th class="px-3 py-2 border">Nama Kelas</th>
                        <th class="px-3 py-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $i => $k)
                        <tr class="hover:bg-gray-50">
                            <td class="px-3 py-2 border">{{ $i + 1 }}</td>
                            <td class="px-3 py-2 border">{{ $k->nama_kelas }}</td>
                            <td class="px-3 py-2 border">
                                <form action="{{ route('admin.kelas.destroy', $k->id) }}" method="POST" onsubmit="return confirm('Yakin hapus kelas ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline">🗑 Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-3 py-4 text-center text-gray-500">Belum ada data kelas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</x-layouts.admin>
