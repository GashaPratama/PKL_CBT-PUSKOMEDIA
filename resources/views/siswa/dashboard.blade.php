<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
</head>

<body class="bg-gradient-to-br from-blue-100 via-white to-purple-100 min-h-screen p-6 font-sans">

    <div class="max-w-6xl mx-auto bg-white p-8 rounded-2xl shadow-lg">
        <h2 class="text-3xl font-bold text-gray-800 mb-6">📚 Selamat Datang di Dashboard Siswa</h2>

        @forelse($ujians as $index => $ujian)
            <div class="overflow-x-auto rounded-lg mb-4">
                <table class="min-w-full divide-y divide-gray-200 border border-gray-300">
                    <thead class="bg-blue-100 text-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-semibold">#</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold">Nama Ujian</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold">Tanggal</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold">Waktu Mulai</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold">Durasi</th>
                            <th class="px-4 py-3 text-left text-sm font-semibold">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        <tr class="{{ $index % 2 === 0 ? 'bg-gray-50' : 'bg-white' }}">
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $index + 1 }}</td>
                            <td class="px-4 py-3 text-sm font-medium text-gray-800">{{ $ujian->nama }}</td>
                            <td class="px-4 py-3 text-sm text-gray-600">
                                {{ \Carbon\Carbon::parse($ujian->tanggal)->translatedFormat('d F Y') }}
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">
                                {{ \Carbon\Carbon::parse($ujian->jadwal_mulai)->translatedFormat('H:i') }} WIB
                            </td>
                            <td class="px-4 py-3 text-sm text-gray-600">{{ $ujian->durasi }} menit</td>
                            <td class="px-4 py-3 space-x-2">
                                <a href="{{ route('siswa.ujian', $ujian->id) }}"
                                   class="inline-flex items-center bg-blue-600 text-white px-3 py-1.5 rounded shadow hover:bg-blue-700 text-sm">
                                    ▶ Kerjakan
                                </a>
                                <button 
                                    onclick="downloadSoal({{ $ujian->id }})"
                                    class="inline-flex items-center bg-green-600 text-white px-3 py-1.5 rounded shadow hover:bg-green-700 text-sm">
                                    📩 Unduh Soal
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        @empty
            <div class="text-center py-12 text-gray-500">
                😔 Belum ada ujian yang tersedia saat ini.
            </div>
        @endforelse
    </div>

    <script>
        function downloadSoal(ujianId) {
            fetch(`/api/ujian/${ujianId}/soal`)
                .then(response => {
                    if (!response.ok) throw new Error('Gagal mengambil soal');
                    return response.json();
                })
                .then(data => {
                    const secretKey = 'kunc!_rahasia123';
                    const encrypted = CryptoJS.AES.encrypt(JSON.stringify(data), secretKey).toString();
                    localStorage.setItem(`ujian_${ujianId}_data`, encrypted);

                    alert("✅ Soal berhasil diunduh! Kamu bisa mengerjakannya secara offline nanti.");
                })
                .catch(error => {
                    console.error(error);
                    alert("❌ Gagal mengunduh soal. Coba lagi.");
                });
        }
    </script>

</body>
</html>
