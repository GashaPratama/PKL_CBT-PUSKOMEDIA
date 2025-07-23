<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tambah User</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
  <div class="max-w-2xl mx-auto bg-white p-6 shadow rounded-lg">
    <h2 class="text-2xl font-bold mb-4 text-gray-800">Tambah Pengguna Baru</h2>

    {{-- Tampilkan Error --}}
    @if($errors->any())
      <div class="mb-4 p-4 bg-red-100 text-red-700 rounded">
        <ul class="list-disc pl-5 text-sm">
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    {{-- Form Tambah Manual --}}
    <form method="POST" action="{{ route('admin.user.store') }}" class="space-y-4 mb-10">
      @csrf

      <div>
        <label class="block text-sm font-medium mb-1">Nama Lengkap</label>
        <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap') }}" required class="w-full border p-2 rounded">
      </div>

      <div>
        <label class="block text-sm font-medium mb-1">Email</label>
        <input type="email" name="email" value="{{ old('email') }}" required class="w-full border p-2 rounded">
      </div>

      <div>
        <label class="block text-sm font-medium mb-1">Password</label>
        <input type="password" name="password" required class="w-full border p-2 rounded">
      </div>

      <div>
        <label class="block text-sm font-medium mb-1">No Telpon</label>
        <input type="text" name="no_telpon" value="{{ old('no_telpon') }}" class="w-full border p-2 rounded">
      </div>

      <div>
        <label class="block text-sm font-medium mb-1">Jenis Kelamin</label>
        <select name="jenis_kelamin" required class="w-full border p-2 rounded">
          <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
          <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
        </select>
      </div>

      {{-- Dropdown Kelas --}}
      <div>
        <label class="block text-sm font-medium mb-1">Kelas</label>
        <select id="kelasSelect" required class="w-full border p-2 rounded">
          <option value="" disabled selected>-- Pilih Kelas --</option>
          @foreach ($kelas as $k)
            <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
          @endforeach
        </select>
      </div>

      {{-- Dropdown Rombongan Belajar --}}
      <div>
        <label class="block text-sm font-medium mb-1">Rombongan Belajar</label>
        <select name="rombongan_belajar_id" id="rombelSelect" required class="w-full border p-2 rounded">
          <option value="" disabled selected>-- Pilih Rombel --</option>
        </select>
      </div>

      <div>
        <label class="block text-sm font-medium mb-1">Role</label>
        <select name="role" required class="w-full border p-2 rounded">
          <option value="siswa" {{ old('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
          <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
        </select>
      </div>

      <div class="pt-2">
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
          Simpan
        </button>
      </div>
    </form>

    {{-- Divider --}}
    <div class="my-6 border-t"></div>

    {{-- Form Upload Excel --}}
    <h3 class="text-lg font-bold mb-4 text-gray-800">Import Pengguna dari Excel</h3>
    <form method="POST" action="{{ route('admin.user.import') }}" enctype="multipart/form-data" class="space-y-4">
      @csrf
      <div>
        <label class="block text-sm font-medium mb-1">Upload File (.xlsx)</label>
        <input type="file" name="file" accept=".xlsx,.xls" class="w-full border p-2 rounded" required>
      </div>

      <div class="flex items-center gap-3">
        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
          Import Excel
        </button>
        <a href="{{ asset('files/template_user.xlsx') }}" download class="text-sm text-blue-600 underline">
          Download Template
        </a>
      </div>
    </form>
  </div>

  {{-- Script untuk filter rombel berdasarkan kelas --}}
  <script>
    const rombels = @json($rombels); // dikirim dari controller

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
</body>
</html>
