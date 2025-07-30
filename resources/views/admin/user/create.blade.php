<x-layouts.admin title="Tambah Pengguna">

    <div class="max-w-3xl mx-auto bg-white p-6 sm:p-8 shadow rounded-xl">
        <h2 class="text-2xl font-bold text-gray-800 mb-6">👤 Tambah Pengguna Baru</h2>

        {{-- Tampilkan Error --}}
        @if($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 p-4 rounded-lg text-sm">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form Manual --}}
        <form method="POST" action="{{ route('admin.user.store') }}" class="space-y-5 mb-10">
            @csrf

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" required class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">No Telepon</label>
                <input type="text" name="no_telpon" value="{{ old('no_telpon') }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Jenis Kelamin</label>
                <select name="jenis_kelamin" required class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                <select id="kelasSelect" required class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="" disabled selected>-- Pilih Kelas --</option>
                    @foreach ($kelas as $k)
                        <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Rombongan Belajar</label>
                <select name="rombongan_belajar_id" id="rombelSelect" required class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="" disabled selected>-- Pilih Rombel --</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Role</label>
                <select name="role" required class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500">
                    <option value="siswa" {{ old('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <div class="pt-3">
                <button type="submit" class="inline-flex items-center bg-blue-600 text-white px-5 py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                    💾 Simpan Pengguna
                </button>
            </div>
        </form>

        {{-- Divider --}}
        <div class="my-8 border-t"></div>

        {{-- Form Import Excel --}}
        <h3 class="text-lg font-bold text-gray-800 mb-4">📥 Import Pengguna dari Excel</h3>

        <form method="POST" action="{{ route('admin.user.import') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Upload File (.xlsx)</label>
                <input type="file" name="file" accept=".xlsx,.xls" class="w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" required>
            </div>

            <div class="flex items-center gap-3 pt-2">
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg font-semibold transition">
                    ⬆️ Import Excel
                </button>
                <a href="{{ asset('files/template_user.xlsx') }}" download class="text-blue-600 underline text-sm hover:text-blue-800">
                    📄 Download Template
                </a>
            </div>
        </form>
    </div>

    {{-- Script Filter Rombel Berdasarkan Kelas --}}
    <script>
        const rombels = @json($rombels);

        const kelasSelect = document.getElementById('kelasSelect');
        const rombelSelect = document.getElementById('rombelSelect');

        kelasSelect.addEventListener('change', function () {
            const selectedKelasId = this.value;
            rombelSelect.innerHTML = '<option value="" disabled selected>-- Pilih Rombel --</option>';

            rombels.forEach(r => {
                if (r.kelas_id == selectedKelasId) {
                    const option = document.createElement('option');
                    option.value = r.id;
                    option.textContent = r.kelas.nama_kelas + ' - Kelompok ' + r.nama_kelompok;
                    rombelSelect.appendChild(option);
                }
            });
        });
    </script>

</x-layouts.admin>
