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
    <!-- Header -->
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

    <!-- Filter Form -->
    <form method="GET" action="{{ route('admin.user.show') }}" class="mb-4 flex flex-wrap gap-3 items-end">
      {{-- Dropdown Kelas --}}
      <div>
        <label class="block text-sm font-medium">Kelas</label>
        <select name="kelas" id="filter-kelas" class="border rounded px-2 py-1 text-sm w-40">
          <option value="">-- Semua --</option>
          @foreach ($kelasList as $kelas)
            <option value="{{ $kelas->id }}" {{ request('kelas') == $kelas->id ? 'selected' : '' }}>
              {{ $kelas->nama_kelas }}
            </option>
          @endforeach
        </select>
      </div>

      {{-- Dropdown Rombel --}}
      <div>
        <label class="block text-sm font-medium">Kelompok</label>
        <select name="kelompok" id="filter-rombel" class="border rounded px-2 py-1 text-sm w-40">
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

      <button type="submit"
              class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 text-sm mt-1 sm:mt-0">
        🔍 Filter
      </button>
      <a href="{{ route('admin.user.show') }}"
         class="text-gray-600 hover:underline text-sm mt-1 sm:mt-0">🔄 Reset</a>
    </form>

    <!-- Success Message -->
    @if(session('success'))
      <div class="mb-4 p-3 bg-green-100 text-green-700 rounded text-sm">
        {{ session('success') }}
      </div>
    @endif

    <!-- Tabel Peserta -->
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
              <td class="p-2">{{ $user->rombonganBelajar->kelas->nama_kelas ?? '-' }}</td>
              <td class="p-2">{{ $user->rombonganBelajar->nama_kelompok ?? '-' }}</td>
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
            <tr>
              <td colspan="8" class="p-3 text-center text-gray-500">Tidak ada data peserta.</td>
            </tr>
          @endforelse
        </tbody>
      </table>

      <a href="{{ route('admin.dashboard') }}"
         class="text-sm text-gray-600 hover:underline mt-4 inline-block">
        ← Kembali
      </a>
    </div>
  </div>

  <script>
    // Filter rombel berdasarkan kelas
    document.getElementById('filter-kelas')?.addEventListener('change', function () {
      const selectedKelasId = this.value;
      const rombelSelect = document.getElementById('filter-rombel');

      Array.from(rombelSelect.options).forEach(option => {
        const kelasId = option.getAttribute('data-kelas');
        if (!kelasId || selectedKelasId === "" || kelasId === selectedKelasId) {
          option.hidden = false;
        } else {
          option.hidden = true;
        }
      });

      // Reset selected rombel jika tidak sesuai
      if (rombelSelect.selectedOptions.length) {
        const selectedOption = rombelSelect.selectedOptions[0];
        if (selectedOption.hidden) {
          rombelSelect.selectedIndex = 0;
        }
      }
    });

    // Trigger filter awal jika ada kelas terpilih
    window.addEventListener('DOMContentLoaded', function () {
      const trigger = document.getElementById('filter-kelas');
      if (trigger?.value !== '') trigger.dispatchEvent(new Event('change'));
    });
  </script>

</body>
</html>
