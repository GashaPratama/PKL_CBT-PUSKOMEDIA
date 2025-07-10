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

        {{-- Header --}}
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-gray-800">📚 Selamat Datang {{ auth()->user()->nama_lengkap }}, Selamat mengerjakan</h2>
            <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Yakin ingin logout?');">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded shadow text-sm">
                    🔒 Logout
                </button>
            </form>
        </div>

        {{-- Daftar Ujian --}}
        @if($ujians->count())
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
                        @foreach($ujians as $index => $ujian)
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
                                    <button 
                                        id="btn-kerjakan-{{ $ujian->id }}"
                                        data-id="{{ $ujian->id }}"
                                        onclick="mulaiUjian({{ $ujian->id }})"
                                        class="btn-kerjakan inline-flex items-center bg-blue-600 text-white px-3 py-1.5 rounded shadow hover:bg-blue-700 text-sm disabled:bg-gray-400 disabled:cursor-not-allowed">
                                        📝 Kerjakan
                                    </button>
                                    <button 
                                        onclick="downloadSoal({{ $ujian->id }})"
                                        class="inline-flex items-center bg-green-600 text-white px-3 py-1.5 rounded shadow hover:bg-green-700 text-sm">
                                        📩 Unduh Soal
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12 text-gray-500">
                😔 Belum ada ujian yang tersedia saat ini.
            </div>
        @endif
    </div>

    {{-- Script --}}
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
                    alert("✅ Soal berhasil diunduh!");
                    location.reload(); // refresh agar tombol 'kerjakan' aktif
                })
                .catch(error => {
                    console.error(error);
                    alert("❌ Gagal mengunduh soal. Coba lagi.");
                });
        }

        function mulaiUjian(ujianId) {
            const encrypted = localStorage.getItem(`ujian_${ujianId}_data`);
            if (!encrypted) {
                alert("❌ Soal belum diunduh! Silakan klik 'Unduh Soal' terlebih dahulu.");
                return;
            }

            window.location.href = `/siswa/ujian/${ujianId}`;
        }

        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.btn-kerjakan').forEach(btn => {
                const ujianId = btn.dataset.id;
                const soal = localStorage.getItem(`ujian_${ujianId}_data`);
                const jawaban = localStorage.getItem(`jawaban_ujian_${ujianId}`);

                if (!soal) {
                    btn.disabled = true;
                }

                if (jawaban) {
                    btn.innerText = "✅ Sudah Dikerjakan";
                    btn.disabled = true;
                    btn.classList.remove("bg-blue-600", "hover:bg-blue-700");
                    btn.classList.add("bg-gray-400", "cursor-not-allowed");
                }
            });
        });
    </script>

</body>
</html>
