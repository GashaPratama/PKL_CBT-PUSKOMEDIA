<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Siswa</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.1.1/crypto-js.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script>
    // Register Service Worker
    if ('serviceWorker' in navigator) {
      navigator.serviceWorker.register('/service-worker.js')
        .then(() => console.log('✅ Service Worker ready'))
        .catch(err => console.error('❌ SW failed:', err));
    }
    </script>
</head>
<body class="bg-gradient-to-br from-blue-100 via-white to-purple-100 min-h-screen font-sans">

    <div class="max-w-4xl mx-auto bg-white mt-4 mb-8 px-4 py-6 sm:p-8 rounded-xl shadow-lg">

        <!-- Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4">
            <h2 class="text-xl sm:text-2xl font-semibold text-gray-800">
                📚 Selamat Datang, {{ auth()->user()->nama_lengkap }}
            </h2>
            <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Yakin ingin logout?');">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded shadow text-sm">
                    🔒 Logout
                </button>
            </form>
        </div>

        <!-- Daftar Ujian -->
        @if($ujians->count())
            <div class="overflow-x-auto rounded-md mb-4">
                <table class="min-w-full divide-y divide-gray-200 border border-gray-300 text-sm">
                    <thead class="bg-blue-100 text-gray-700">
                        <tr>
                            <th class="px-4 py-2 text-left font-semibold">#</th>
                            <th class="px-4 py-2 text-left font-semibold">Nama Ujian</th>
                            <th class="px-4 py-2 text-left font-semibold">Tanggal</th>
                            <th class="px-4 py-2 text-left font-semibold">Waktu Mulai</th>
                            <th class="px-4 py-2 text-left font-semibold">Durasi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-100">
                        @foreach($ujians as $index => $ujian)
                            <tr class="{{ $index % 2 === 0 ? 'bg-gray-50' : 'bg-white' }}">
                                <td class="px-4 py-2 text-gray-600">{{ $index + 1 }}</td>
                                <td class="px-4 py-2 font-medium text-gray-800">{{ $ujian->nama }}</td>
                                <td class="px-4 py-2 text-gray-600">{{ \Carbon\Carbon::parse($ujian->tanggal)->translatedFormat('d F Y') }}</td>
                                <td class="px-4 py-2 text-gray-600">{{ \Carbon\Carbon::parse($ujian->waktu_mulai)->translatedFormat('H:i') }} WIB</td>
                                <td class="px-4 py-2 text-gray-600">{{ $ujian->durasi }} menit</td>
                            </tr>
                            <tr>
                                <td colspan="5" class="px-4 py-2">
                                    <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-3">
                                        <button 
                                            id="btn-kerjakan-{{ $ujian->id }}"
                                            data-id="{{ $ujian->id }}"
                                            onclick="mulaiUjian({{ $ujian->id }})"
                                            class="btn-kerjakan flex-1 sm:flex-none inline-flex items-center justify-center bg-blue-600 text-white px-4 py-2 rounded shadow hover:bg-blue-700 text-sm disabled:bg-gray-400 disabled:cursor-not-allowed">
                                            📝 Kerjakan
                                        </button>
                                        <button 
                                            onclick="downloadSoal({{ $ujian->id }})"
                                            class="flex-1 sm:flex-none inline-flex items-center justify-center bg-green-600 text-white px-4 py-2 rounded shadow hover:bg-green-700 text-sm">
                                            📩 Unduh Soal
                                        </button>
                                        <button 
                                            onclick="kirimHasilUjian(this)" 
                                            data-ujian-id="{{ $ujian->id }}" 
                                            class="flex-1 sm:flex-none inline-flex items-center justify-center bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded text-sm">
                                            🚀 Kirim Hasil Ujian
                                        </button>
                                    </div>
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

    <!-- Script -->
    <script>
    const secretKey = 'kunc!_rahasia123';

    /**
     * Unduh soal dari API, simpan terenkripsi ke localStorage,
     * lalu preload semua gambar soal untuk offline.
     */
    function downloadSoal(ujianId) {
        fetch(`/api/ujian/${ujianId}/soal`)
            .then(response => {
                if (!response.ok) throw new Error('Gagal mengambil soal');
                return response.json();
            })
            .then(data => {
                // Normalisasi: huruf kunci ke uppercase
                if (data.soal && Array.isArray(data.soal)) {
                    data.soal.forEach(item => {
                        if (item.jawaban_benar) {
                            item.jawaban_benar = item.jawaban_benar.toUpperCase();
                        }
                    });
                }

                // Simpan terenkripsi
                const encrypted = CryptoJS.AES.encrypt(JSON.stringify(data), secretKey).toString();
                localStorage.setItem(`ujian_${ujianId}_data`, encrypted);

                // Preload gambar untuk ujian ini
                preloadGambarUjian(ujianId);

                alert("✅ Soal berhasil diunduh!");
                location.reload();
            })
            .catch(error => {
                console.error(error);
                alert("❌ Gagal mengunduh soal. Coba lagi.");
            });
    }

    /**
     * Buka data (encrypted/legacy raw) dari localStorage.
     * Mengembalikan object atau null jika gagal.
     */
    function getSoalData(ujianId) {
        const raw = localStorage.getItem(`ujian_${ujianId}_data`);
        if (!raw) return null;

        // Coba decrypt; jika gagal, anggap raw JSON (data lama)
        let jsonStr;
        try {
            const decrypted = CryptoJS.AES.decrypt(raw, secretKey).toString(CryptoJS.enc.Utf8);
            jsonStr = decrypted || raw;
        } catch {
            jsonStr = raw;
        }

        try {
            return JSON.parse(jsonStr);
        } catch (e) {
            console.error("❌ Gagal parse soal ujian", ujianId, e);
            return null;
        }
    }

    /**
     * Preload semua gambar soal untuk 1 ujian (agar tersedia offline).
     */
    function preloadGambarUjian(ujianId) {
        const data = getSoalData(ujianId);
        if (!data || !Array.isArray(data.soal)) return;

        data.soal.forEach(s => {
            if (s.gambar) {
                const img = new Image();
                img.src = `/img/soal/${s.gambar}`;
                console.log("📥 Preloading:", img.src);
            }
        });
    }

    /**
     * Preload semua gambar soal dari semua ujian yang sudah diunduh.
     * Dipanggil saat dashboard load.
     */
    function preloadSemuaGambar() {
        const semuaUjian = @json($ujians->pluck('id'));
        semuaUjian.forEach(id => preloadGambarUjian(id));
    }

    /**
     * Mulai ujian: validasi data & jadwal, lalu redirect ke halaman ujian.
     */
    function mulaiUjian(ujianId) {
        const encrypted = localStorage.getItem(`ujian_${ujianId}_data`);
        if (!encrypted) {
            alert("❌ Soal belum diunduh!");
            return;
        }

        const jawaban = localStorage.getItem(`jawaban_ujian_${ujianId}`);
        if (jawaban) {
            alert("✅ Ujian ini sudah selesai dikerjakan.");
            return;
        }

        const data = getSoalData(ujianId);
        if (!data) {
            alert("❌ Gagal memuat data ujian.");
            return;
        }

        // Jadwal bisa ada di root (versi lama) atau di data.ujian
        const mulaiRaw = data.jadwal_mulai ?? data?.ujian?.jadwal_mulai;
        if (!mulaiRaw) {
            alert("❌ Jadwal ujian tidak ditemukan.");
            return;
        }

        const jadwalMulai = new Date(mulaiRaw);
        const now = new Date();
        if (now < jadwalMulai) {
            alert("⏰ Belum waktunya mengerjakan ujian ini.");
            return;
        }

        window.location.href = `/siswa/ujian/${ujianId}`;
    }

    /**
     * Kondisikan state tombol "Kerjakan" di tabel ujian.
     * Menonaktifkan bila belum waktunya, sudah dikerjakan, data corrupt, dll.
     */
    document.addEventListener('DOMContentLoaded', function () {
        const now = new Date();

        document.querySelectorAll('.btn-kerjakan').forEach(btn => {
            const ujianId = btn.dataset.id;
            const soalRaw = localStorage.getItem(`ujian_${ujianId}_data`);
            const jawaban = localStorage.getItem(`jawaban_ujian_${ujianId}`);

            if (!soalRaw) {
                btn.disabled = true;
                btn.innerText = "⬇️ Unduh Dulu";
                btn.classList.add("bg-gray-400", "cursor-not-allowed");
                return;
            }

            const data = getSoalData(ujianId);
            if (!data) {
                btn.disabled = true;
                btn.innerText = "❌ Data Corrupt";
                btn.classList.add("bg-gray-400", "cursor-not-allowed");
                return;
            }

            const mulaiRaw = data?.jadwal_mulai ?? data?.ujian?.jadwal_mulai;
            if (!mulaiRaw) {
                btn.disabled = true;
                btn.innerText = "❌ Data Tidak Lengkap";
                btn.classList.add("bg-gray-400", "cursor-not-allowed");
                return;
            }

            const mulai = new Date(mulaiRaw);
            const selesai = new Date(mulai.getTime() + 2 * 60 * 60 * 1000); // +2 jam temp; ganti sesuai bisnis

            if (isNaN(mulai.getTime())) {
                btn.disabled = true;
                btn.innerText = "❌ Jadwal Salah";
                btn.classList.add("bg-gray-400", "cursor-not-allowed");
                return;
            }

            if (now < mulai) {
                btn.disabled = true;
                btn.innerText = `⏰ Belum Waktunya`;
                btn.classList.add("bg-yellow-400", "cursor-not-allowed");
                return;
            }

            if (now > selesai) {
                btn.disabled = true;
                btn.innerText = `⛔ Waktu Habis`;
                btn.classList.add("bg-red-500", "cursor-not-allowed");
                return;
            }

            if (jawaban) {
                btn.disabled = true;
                btn.innerText = "✅ Sudah Dikerjakan";
                btn.classList.remove("bg-blue-600", "hover:bg-blue-700");
                btn.classList.add("bg-gray-400", "cursor-not-allowed");
            }
        });

        // Setelah tabel siap, preload semua gambar dari ujian yang sudah diunduh
        preloadSemuaGambar();
    });

    /**
     * Kirim hasil ujian ke server.
     */
    function kirimHasilUjian(button) {
        const ujianId = button.getAttribute('data-ujian-id');
        const jawabanDataRaw = localStorage.getItem(`jawaban_ujian_${ujianId}`);
        const waktuMulaiRaw = localStorage.getItem(`ujian_${ujianId}_waktu_mulai`);
        const soalRaw = localStorage.getItem(`ujian_${ujianId}_data`);

        if (!jawabanDataRaw || !waktuMulaiRaw || !soalRaw) {
            alert("❌ Data tidak lengkap. Tidak bisa mengirim hasil.");
            return;
        }

        let jawabanData;
        try { jawabanData = JSON.parse(jawabanDataRaw); }
        catch { alert("❌ Data jawaban corrupt."); return; }

        const data = getSoalData(ujianId);
        if (!data) {
            alert("❌ Gagal dekripsi soal.");
            return;
        }

        const jawabanUser = jawabanData.jawaban || {};
        let jumlahBenar = 0;

        (data.soal || []).forEach(item => {
            const kunci = item.jawaban_benar?.toUpperCase();
            const jawaban = jawabanUser[item.id];
            if (jawaban && jawaban === kunci) jumlahBenar++;
        });

        const nilai = Math.round((jumlahBenar / (data.soal?.length || 1)) * 100);
        const waktuMulai = new Date(waktuMulaiRaw).toISOString().slice(0, 19).replace("T", " ");
        const waktuSelesai = new Date().toISOString().slice(0, 19).replace("T", " ");

        fetch("{{ route('siswa.submit-hasil') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                ujian_id: ujianId,
                nilai: nilai,
                waktu_mulai: waktuMulai,
                waktu_selesai: waktuSelesai
            })
        })
        .then(res => res.json())
        .then(res => {
            if (res.status === 'success') {
                alert("✅ Nilai berhasil dikirim.");
                localStorage.removeItem(`ujian_${ujianId}_waktu_mulai`);
                localStorage.removeItem(`ujian_${ujianId}_acak`);
                window.location.href = "/siswa/dashboard";
            } else {
                alert("❌ Gagal mengirim: " + res.message);
            }
        })
        .catch(err => {
            console.error(err);
            alert("❌ Gagal mengirim data.");
        });
    }
    </script>

</body>
</html>
