<x-layouts.admin title="Daftar Ujian - CBT">

    <div class="max-w-6xl mx-auto bg-white shadow-md rounded-xl p-6 sm:p-8">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-3">
            <h2 class="text-2xl font-bold text-gray-800">📘 Daftar Ujian</h2>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('admin.ujian.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow transition">
                    ➕ Tambah Ujian
                </a>
                
            </div>
        </div>

        <!-- Notifikasi -->
        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 border border-green-300 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tabel Ujian -->
        <div class="w-full overflow-x-auto border rounded-lg">
            <table class="min-w-full text-sm">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="p-3 border">#</th>
                        <th class="p-3 border">Nama Ujian</th>
                        <th class="p-3 border">Tanggal</th>
                        <th class="p-3 border">Peserta</th>
                        <th class="p-3 border text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($ujians as $index => $ujian)
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 border">
                                {{ ($ujians->currentPage() - 1) * $ujians->perPage() + $index + 1 }}
                            </td>
                            <td class="p-3 border">{{ $ujian->nama }}</td>
                            <td class="p-3 border">
                                {{ \Carbon\Carbon::parse($ujian->jadwalMulai)->translatedFormat('d F Y') }}
                            </td>
                            <td class="p-3 border">{{ $ujian->jumlah_peserta ?? '-' }}</td>
                            <td class="p-3 border">
                                <div class="flex flex-wrap justify-center gap-2 text-sm">
                                    <a href="{{ route('admin.ujian.detail', $ujian->id) }}" class="text-blue-600 hover:underline">Detail</a>
                                    <a href="{{ route('admin.ujian.edit', $ujian->id) }}" class="text-green-600 hover:underline">Edit</a>
                                    <a href="{{ route('admin.nilai.show', $ujian->id) }}" class="text-indigo-600 hover:underline">Nilai</a>
                                    <a href="{{ route('admin.gambar.form') }}" class="text-indigo-600 hover:underline">Upload Gambar</a>
                                    <a href="{{ route('admin.ujian.simulasi', $ujian->id) }}" class="text-yellow-600 hover:underline">🧪 Simulasi</a>
                                    <a href="{{ route('admin.ujian.export.excel', $ujian->id) }}" class="text-yellow-600 hover:underline">📊 Export</a>
                                    <form action="{{ route('admin.ujian.destroy', $ujian->id) }}" method="POST" onsubmit="return confirm('Yakin hapus ujian ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:underline">🗑 Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-4 text-center text-gray-500">Belum ada ujian tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Navigasi Pagination -->
        <div class="mt-6">
            {{ $ujians->appends(request()->query())->links('vendor.pagination.tailwind') }}
            
        </div>

    </div>

</x-layouts.admin>
