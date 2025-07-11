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
    <nav class="bg-blue-600 text-white p-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-4">
            <h1 class="text-base sm:text-lg font-semibold">Selamat Datang, {{ auth()->user()->nama_lengkap }}</h1>
            <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Yakin ingin logout?');">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded shadow text-sm">
                    🔒 Logout
                </button>
            </form>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-1 max-w-7xl mx-auto mt-6 px-4">

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

        <!-- Aksi Admin -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-6">
            <div class="bg-white shadow rounded-lg p-4 flex justify-between items-center">
                <span class="font-medium">Tambah Ujian</span>
                <a href="{{ route('admin.ujian.create') }}" class="w-9 h-9 flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white rounded-full text-xl">+</a>
            </div>
            <div class="bg-white shadow rounded-lg p-4 flex justify-between items-center">
                <span class="font-medium">Tambah Peserta</span>
                <a href="{{ route('admin.user.create') }}" class="w-9 h-9 flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white rounded-full text-xl">+</a>
            </div>
            <div class="bg-white shadow rounded-lg p-4 flex justify-between items-center">
                <span class="font-medium">Data Peserta</span>
                <a href="{{ route('admin.user.show') }}" class="w-9 h-9 flex items-center justify-center bg-blue-600 hover:bg-blue-700 text-white rounded-full text-xl">👁</a>
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
                            <td class="px-2 py-2 border">
                                {{ \Carbon\Carbon::parse($ujian->jadwalMulai)->translatedFormat('d F Y') }}
                            </td>
                            <td class="px-2 py-2 border">{{ $ujian->jumlah_peserta ?? '-' }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="px-2 pt-1 pb-3 border text-sm">
                                <div class="flex flex-wrap gap-2">
                                    <a href="{{ route('admin.ujian.detail', $ujian->id) }}" class="text-blue-500 hover:underline">Detail</a>
                                    <a href="{{ route('admin.ujian.edit', $ujian->id) }}" class="text-green-500 hover:underline">Edit</a>
                                    <a href="{{ route('admin.nilai.show', $ujian->id) }}" class="text-indigo-500 hover:underline">Nilai</a>
                                    <a href="{{ route('admin.ujian.simulasi', $ujian->id) }}" class="text-yellow-500 hover:underline">🧪 Simulasi</a>
                                    <a href="{{ route('admin.ujian.export.excel', $ujian->id) }}" class="text-yellow-600 hover:underline">📊 Excel</a>
                                    <a href="{{ route('admin.ujian.export.pdf', $ujian->id) }}" class="text-red-600 hover:underline">📄 PDF</a>
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
</body>
</html>
