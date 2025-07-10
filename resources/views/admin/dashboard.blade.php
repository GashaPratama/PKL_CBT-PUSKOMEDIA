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
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-lg font-semibold">Selamat Datang, {{ auth()->user()->nama_lengkap }}</h1>
            <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Yakin ingin logout?');">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded shadow text-sm">
                    🔒 Logout
                </button>
            </form>
        </div>
    </nav>

    <!-- Main Content -->
    
    <main class="flex-1 container mx-auto mt-8 px-4">

         <!-- Dashboard Main  -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white shadow rounded-lg p-6 text-center">
                 <h2 class="text-lg font-semibold mb-2">Total Ujian</h2>
                 <p class="text-3xl font-bold text-blue-600">{{ $totalUjian }}</p>
            </div>
            <div class="bg-white shadow rounded-lg p-6 text-center">
                <h2 class="text-lg font-semibold mb-2">Peserta Terdaftar</h2>
                <p class="text-3xl font-bold text-green-600">{{ $totalSiswa }}</p>
            </div>
            <div class="bg-white shadow rounded-lg p-6 text-center">
                <h2 class="text-lg font-semibold mb-2">Waktu Sekarang</h2>
                <p class="text-lg font-bold text-green-500">
                {{ \Carbon\Carbon::now()->translatedFormat('l, j F Y \j\a\m H:i') }}
                 </p>
            </div>
        </div>
        <!-- Dashboard Main End -->

        <!-- Add Dashboard -->

        <div class="mt-3 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white shadow rounded-lg p-6 text-center">
                <h2 class="text-lg font-semibold mb-2">Tambah Ujian</h2>
                <a href="{{ route('admin.ujian.create') }}" 
                     class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-600 text-white text-2xl hover:bg-blue-700 transition duration-200">
                      +
                </a>
            </div>
            <div class="bg-white shadow rounded-lg p-6 text-center">
                <h2 class="text-lg font-semibold mb-2">Tambah Peserta</h2>
                <a href="{{ route('admin.user.create') }}" 
                     class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-600 text-white text-2xl hover:bg-blue-700 transition duration-200">
                      +
                </a>
            </div>
             <div class="bg-white shadow rounded-lg p-6 text-center">
                <h2 class="text-lg font-semibold mb-2">Data Peserta</h2>
                <a href="{{ route('admin.user.show') }}" 
                     class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-blue-600 text-white text-2xl hover:bg-blue-700 transition duration-200">
                      👁
                </a>
            </div>
        </div>

        <!-- Add Dashboard End -->


        <!-- Ringkasan Ujian Terakhir -->
<div class="mt-10 bg-white shadow rounded-lg p-6 overflow-x-auto">
    <h2 class="text-xl font-semibold mb-4">Daftar Ujian</h2>
    <table class="min-w-full table-auto text-left border border-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="px-4 py-2 border">#</th>
                <th class="px-4 py-2 border">Nama Ujian</th>
                <th class="px-4 py-2 border">Tanggal</th>
                <th class="px-4 py-2 border">Jumlah Peserta</th>
                <th class="px-4 py-2 border">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ujians as $index => $ujian)
                <tr>
                    <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                    <td class="px-4 py-2 border">{{ $ujian->nama }}</td>
                    <td class="px-4 py-2 border">
                        {{ \Carbon\Carbon::parse($ujian->jadwalMulai)->translatedFormat('d F Y') }}
                    </td>
                    <td class="px-4 py-2 border">{{ $ujian->jumlah_peserta ?? '-' }}</td>
                    <td class="px-4 py-2 border space-y-1">
                        <a href="{{ route('admin.ujian.detail', $ujian->id) }}" class="text-blue-500 hover:underline mr-2">Detail</a>
                        <a href="{{ route('admin.ujian.edit', $ujian->id) }}" class="text-green-500 hover:underline mr-2">Edit</a>
                        <a href="{{ route('admin.nilai.show', $ujian->id) }}" class="text-indigo-500 hover:underline mr-2">Lihat Nilai</a>
                        <a href="{{ route('admin.ujian.simulasi', $ujian->id) }}" class="text-yellow-500 hover:underline mr-2">🧪 Simulasi</a>


                        <div class="flex flex-wrap gap-2 mt-1">
                            <a href="{{ route('admin.ujian.export.excel', $ujian->id) }}" class="text-yellow-600 hover:underline text-sm">📊 Excel</a>
                            <a href="{{ route('admin.ujian.export.pdf', $ujian->id) }}" class="text-red-600 hover:underline text-sm">📄 PDF</a>
                        </div>

                        <form action="{{ route('admin.ujian.destroy', $ujian->id) }}" method="POST" class="inline-block mt-1" onsubmit="return confirm('Yakin hapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
<!-- Ringkasan Ujian Terakhir End-->

    </main>

</body>
</html>
