<x-layouts.admin title="Data Peserta">

    <div class="max-w-6xl mx-auto bg-white shadow-md rounded-xl p-6 sm:p-8">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-3">
            <h2 class="text-2xl font-bold text-gray-800">📋 Daftar Peserta</h2>
            <div class="flex gap-2">
                <a href="{{ route('admin.user.export.excel') }}"
                   class="bg-green-600 text-white px-4 py-2 text-sm rounded-lg hover:bg-green-700 transition">
                   📥 Export Excel
                </a>
                <a href="{{ route('admin.user.export.pdf') }}"
                   class="bg-red-600 text-white px-4 py-2 text-sm rounded-lg hover:bg-red-700 transition">
                   📄 Export PDF
                </a>
            </div>
        </div>

        <!-- Filter Form -->
        <form method="GET" action="{{ route('admin.user.show') }}" class="mb-6 flex flex-wrap gap-4 items-end">
            <!-- Kelas -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                <select name="kelas" id="filter-kelas" class="w-40 rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 text-sm">
                    <option value="">-- Semua --</option>
                    @foreach ($kelasList as $kelas)
                        <option value="{{ $kelas->id }}" {{ request('kelas') == $kelas->id ? 'selected' : '' }}>
                            {{ $kelas->nama_kelas }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Rombel -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kelompok</label>
                <select name="kelompok" id="filter-rombel" class="w-48 rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 text-sm">
                    <option value="">-- Semua --</option>
                    @foreach ($rombelList as $rombel)
                        <option value="{{ $rombel->id }}"
                                data-kelas="{{ $rombel->kelas_id }}"
                                {{ request('kelompok') == $rombel->id ? 'selected' : '' }}>
                            {{ $rombel->nama_kelompok }} ({{ $rombel->kelas->nama_kelas }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-700 transition">
                    🔍 Filter
                </button>
                <a href="{{ route('admin.user.show') }}"
                   class="text-gray-600 hover:underline text-sm mt-2 sm:mt-[10px] block">🔄 Reset</a>
            </div>
        </form>

        <!-- Success Message -->
        @if(session('success'))
            <div class="mb-6 p-3 bg-green-100 text-green-700 border border-green-400 rounded-lg text-sm">
                {{ session('success') }}
            </div>
        @endif

        <!-- Tabel Peserta -->
        <div class="overflow-x-auto rounded-lg border border-gray-200">
            <table class="min-w-full bg-white text-sm text-left">
                <thead class="bg-gray-100 text-gray-700">
                    <tr>
                        <th class="p-3 border">#</th>
                        <th class="p-3 border">Nama</th>
                        <th class="p-3 border">Email</th>
                        <th class="p-3 border">No Telp</th>
                        <th class="p-3 border">Gender</th>
                        <th class="p-3 border">Kelas</th>
                        <th class="p-3 border">Kelompok</th>
                        <th class="p-3 border text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $index => $user)
                        <tr class="hover:bg-gray-50">
                            <td class="p-3 border">
                                {{ ($users->currentPage() - 1) * $users->perPage() + $index + 1 }}
                            </td>
                            <td class="p-3 border">{{ $user->nama_lengkap }}</td>
                            <td class="p-3 border">{{ $user->email }}</td>
                            <td class="p-3 border">{{ $user->no_telpon }}</td>
                            <td class="p-3 border">{{ $user->jenis_kelamin }}</td>
                            <td class="p-3 border">{{ $user->rombonganBelajar->kelas->nama_kelas ?? '-' }}</td>
                            <td class="p-3 border">{{ $user->rombonganBelajar->nama_kelompok ?? '-' }}</td>
                            <td class="p-3 border text-sm text-center">
                                <div class="flex justify-center gap-2 flex-wrap">
                                    <form action="{{ route('admin.user.reset', $user->id_user) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                                onclick="return confirm('Reset password untuk {{ $user->nama_lengkap }} ke default?')"
                                                class="text-blue-600 hover:underline">
                                            🔁 Reset
                                        </button>
                                    </form>
                                    <a href="{{ route('admin.user.edit', $user->id_user) }}"
                                       class="text-yellow-600 hover:underline">
                                       ✏️ Edit
                                    </a>
                                    <form action="{{ route('admin.user.destroy', $user->id_user) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                onclick="return confirm('Yakin ingin menghapus {{ $user->nama_lengkap }}?')"
                                                class="text-red-600 hover:underline">
                                            🗑 Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-4 text-center text-gray-500">Tidak ada data peserta.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Navigasi Pagination -->
        <div class="mt-6">
            {{ $users->appends(request()->query())->links('vendor.pagination.tailwind') }}
        </div>

        <a href="{{ route('admin.dashboard') }}"
           class="text-sm text-gray-600 hover:underline mt-6 inline-block">
           ← Kembali ke Dashboard
        </a>
    </div>

    <script>
        // Filter rombel berdasarkan kelas
        document.getElementById('filter-kelas')?.addEventListener('change', function () {
            const selectedKelasId = this.value;
            const rombelSelect = document.getElementById('filter-rombel');

            Array.from(rombelSelect.options).forEach(option => {
                const kelasId = option.getAttribute('data-kelas');
                option.hidden = !(!kelasId || selectedKelasId === "" || kelasId === selectedKelasId);
            });

            const selectedOption = rombelSelect.selectedOptions[0];
            if (selectedOption?.hidden) {
                rombelSelect.selectedIndex = 0;
            }
        });

        window.addEventListener('DOMContentLoaded', function () {
            const trigger = document.getElementById('filter-kelas');
            if (trigger?.value !== '') trigger.dispatchEvent(new Event('change'));
        });
    </script>

</x-layouts.admin>
