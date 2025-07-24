<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin - CBT</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col font-sans">

  <!-- Navbar -->
  <nav class="bg-blue-600 text-white py-4 shadow">
    <div class="max-w-7xl mx-auto w-full px-4">
        <div class="flex justify-between items-center w-full">
        <h1 class="text-base sm:text-lg font-semibold">
            Selamat Datang, {{ auth()->user()->nama_lengkap }}
        </h1>
        <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Yakin ingin logout?');">
            @csrf
            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded shadow text-sm">
            🔒 Logout
            </button>
        </form>
        </div>
    </div>
    </nav>

  <div class="flex flex-1 overflow-hidden">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-xl border-r p-4 hidden md:block">
      
      <nav class="space-y-2">
        <a href="{{ route('admin.ujian.create') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-100 text-blue-700 font-medium transition">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M12 4v16m8-8H4" />
          </svg>
          Tambah Ujian
        </a>
        <a href="{{ route('admin.user.create') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-100 text-blue-700 font-medium transition">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M18 9a3 3 0 1 0-6 0v6a3 3 0 1 0 6 0V9zm-9 6H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h3" />
          </svg>
          Tambah Peserta
        </a>
        <a href="{{ route('admin.user.show') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-100 text-blue-700 font-medium transition">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M5.121 17.804A11.969 11.969 0 0 1 12 15c2.645 0 5.072.857 6.879 2.304M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0z" />
          </svg>
          Data Peserta
        </a>
        <a href="{{ route('admin.kelas.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-100 text-blue-700 font-medium transition">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M3 7h18M3 12h18M3 17h18" />
          </svg>
          Manajemen Kelas
        </a>
        <a href="{{ route('admin.rombel.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-100 text-blue-700 font-medium transition">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M17 20h5v-2a3 3 0 0 0-5.356-1.857M9 20H4v-2a3 3 0 0 1 5.356-1.857M16 3.13a4 4 0 1 1-1 7.753A4 4 0 0 1 16 3.13zM8 3.13a4 4 0 1 0 1 7.753A4 4 0 0 0 8 3.13z" />
          </svg>
          Manajemen Rombel
        </a>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto p-4 sm:p-6">
      <!-- Statistik -->
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-6">
        <div class="bg-white shadow rounded-lg p-6 text-center">
          <h2 class="text-base font-semibold mb-1">Total Ujian</h2>
          <p class="text-3xl font-bold text-blue-600">{{ $totalUjian }}</p>
        </div>
        <div class="bg-white shadow rounded-lg p-6 text-center">
          <h2 class="text-base font-semibold mb-1">Peserta Terdaftar</h2>
          <p class="text-3xl font-bold text-green-600">{{ $totalSiswa }}</p>
        </div>
        <div class="bg-white shadow rounded-lg p-6 text-center">
          <h2 class="text-base font-semibold mb-1">Waktu Sekarang</h2>
          <p class="text-sm font-bold text-green-500">
            {{ \Carbon\Carbon::now()->translatedFormat('l, j F Y \j\a\m H:i') }}
          </p>
        </div>
      </div>

      <!-- Tabel Ujian -->
      <div class="bg-white shadow rounded-lg p-4 sm:p-6">
        <h2 class="text-xl font-semibold mb-4">Daftar Ujian</h2>

        <div class="w-full overflow-x-auto">
          <table class="w-full table-fixed text-left border border-gray-200 text-sm sm:text-base">
            <thead class="bg-gray-100">
              <tr>
                <th class="w-1/12 px-2 py-2 border">#</th>
                <th class="w-2/5 px-2 py-2 border">Nama Ujian</th>
                <th class="w-1/4 px-2 py-2 border">Tanggal</th>
                <th class="w-1/6 px-2 py-2 border">Peserta</th>
              </tr>
            </thead>
            <tbody>
              @foreach($ujians as $index => $ujian)
              <tr>
                <td class="px-2 py-2 border">{{ $index + 1 }}</td>
                <td class="px-2 py-2 border break-words">{{ $ujian->nama }}</td>
                <td class="px-2 py-2 border">{{ \Carbon\Carbon::parse($ujian->jadwalMulai)->translatedFormat('d F Y') }}</td>
                <td class="px-2 py-2 border">{{ $ujian->jumlah_peserta ?? '-' }}</td>
              </tr>
              <tr>
                <td colspan="4" class="px-2 pt-1 pb-3 border text-sm">
                  <div class="flex flex-wrap gap-2">
                    <a href="{{ route('admin.ujian.detail', $ujian->id) }}" class="text-blue-500 hover:underline">Detail</a>
                    <a href="{{ route('admin.ujian.edit', $ujian->id) }}" class="text-green-500 hover:underline">Edit</a>
                    <a href="{{ route('admin.nilai.show', $ujian->id) }}" class="text-indigo-500 hover:underline">Nilai</a>
                    <a href="{{ route('admin.gambar.form') }}" class="text-indigo-500 hover:underline">Upload Gambar Soal</a>
                    <a href="{{ route('admin.ujian.simulasi', $ujian->id) }}" class="text-yellow-500 hover:underline">🧪 Simulasi</a>
                    <a href="{{ route('admin.ujian.export.excel', $ujian->id) }}" class="text-yellow-600 hover:underline">📊 Export Excel</a>
                    <form action="{{ route('admin.ujian.destroy', $ujian->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?')">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                    </form>
                  </div>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>
</body>
</html>
