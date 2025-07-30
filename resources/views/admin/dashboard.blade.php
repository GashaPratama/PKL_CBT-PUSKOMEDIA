<x-layouts.admin title="Dashboard Admin - CBT">
    <div class="max-w-6xl mx-auto">

        <!-- Statistik Ringkas -->
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-4 mb-8">
            <!-- Total Ujian -->
            <div class="bg-white shadow rounded-lg p-6 text-center">
                <h2 class="text-base font-semibold text-gray-600 mb-1">📚 Total Ujian</h2>
                <p class="text-3xl font-bold text-blue-600">{{ $totalUjian }}</p>
            </div>

            <!-- Total Siswa -->
            <div class="bg-white shadow rounded-lg p-6 text-center">
                <h2 class="text-base font-semibold text-gray-600 mb-1">👩‍🎓 Peserta Terdaftar</h2>
                <p class="text-3xl font-bold text-green-600">{{ $totalSiswa }}</p>
            </div>

            <!-- Waktu Saat Ini -->
            <div class="bg-white shadow rounded-lg p-6 text-center">
                <h2 class="text-base font-semibold text-gray-600 mb-1">⏰ Waktu Sekarang</h2>
                <p class="text-sm font-bold text-gray-800">
                    {{ \Carbon\Carbon::now()->translatedFormat('l, j F Y \p\u\k\u\l H:i') }}
                </p>
            </div>
        </div>

        <div class="max-w-6xl mx-auto">

        <!-- Header -->
        <h2 class="text-2xl font-bold text-gray-800 mb-6">Dashboard 🧭</h2>

        <!-- Grid: Jadwal + Logo Sekolah -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Kartu: Jadwal Ujian Hari Ini -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">📅 Jadwal Ujian Hari Ini</h3>

                @if($ujianHariIni->isEmpty())
                    <p class="text-sm text-gray-500">Tidak ada ujian hari ini</p>
                @else
                    <table class="w-full text-sm border border-gray-200 rounded">
                        <thead class="bg-gray-100">
                            <tr>
                                <th class="py-2 px-3 text-left">Ujian</th>
                                <th class="py-2 px-3 text-left">Kelas</th>
                                <th class="py-2 px-3 text-left">Token</th>
                                <th class="py-2 px-3 text-left">Jam</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($ujianHariIni as $ujian)
                                <tr class="border-t">
                                    <td class="py-2 px-3">{{ $ujian->nama }}</td>
                                    <td class="py-2 px-3">{{ $ujian->kelas ?? '-' }}</td>
                                    <td class="py-2 px-3">{{ $ujian->token ?? '-' }}</td>
                                    <td class="py-2 px-3">{{ \Carbon\Carbon::parse($ujian->jam_mulai)->format('H:i') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>

            <!-- Kartu: Logo Sekolah -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">🏫 Logo Sekolah</h3>

                @if (session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-700 border border-green-300 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('admin.uploadLogoLogin') }}" method="POST" enctype="multipart/form-data" class="mb-4 space-y-3">
                    @csrf
                    <input type="file" name="logo_login" accept="image/*" required
                        class="w-full border border-gray-300 rounded p-2 file:mr-3 file:py-2 file:px-4 file:rounded file:border-0 file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />
                    <button type="submit"
                        class="bg-gray-700 hover:bg-gray-800 text-white px-4 py-2 rounded text-sm shadow">
                        Unggah Logo
                    </button>
                </form>

                @php
                    $logoLogin = \Illuminate\Support\Facades\DB::table('settings')->where('nama_konfigurasi', 'logo_login')->value('nilai') ?? 'img/login1.png';
                @endphp

                <div class="mt-4">
                    <p class="text-sm text-gray-600 mb-2">📷 Preview:</p>
                    <img src="{{ asset('storage/' . $logoLogin) }}" alt="Logo Sekolah" class="h-24 object-contain rounded border bg-gray-50 p-2">
                </div>
            </div>
        </div>

    </div>

    </div>
</x-layouts.admin>
