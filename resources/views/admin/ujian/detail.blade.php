<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Ujian</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        // Script Select All
        function toggleSelectAll(source) {
            const checkboxes = document.getElementsByName('soal_ids[]');
            for (let i = 0; i < checkboxes.length; i++) {
                checkboxes[i].checked = source.checked;
            }
        }
    </script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
    <div class="max-w-4xl mx-auto bg-white shadow-md rounded p-6">
        <h1 class="text-2xl font-semibold mb-4">Detail Ujian</h1>

        <!-- Info Ujian -->
        <div class="mb-4 space-y-2">
            <p><strong>Nama Ujian:</strong> {{ $exam->nama }}</p>
            <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($exam->tanggal)->translatedFormat('d F Y') }}</p>
            <p><strong>Jumlah Peserta:</strong> {{ $exam->jumlah_peserta }}</p>
            <p><strong>Deskripsi:</strong> {{ $exam->deskripsi }}</p>
            <p><strong>Waktu Mulai:</strong> {{ \Carbon\Carbon::parse($exam->waktu_mulai)->translatedFormat('d F Y H:i') }}</p>
            <p><strong>Waktu Selesai:</strong> {{ \Carbon\Carbon::parse($exam->waktu_selesai)->translatedFormat('d F Y H:i') }}</p>
            <p><strong>Jumlah Percobaan:</strong> {{ $exam->jumlah_percobaan }}</p>
            <p><strong>Durasi Ujian:</strong> {{ $exam->durasi }} menit</p>
        </div>

        <!-- Daftar Soal -->
        <hr class="my-6">
        <h2 class="text-xl font-semibold mb-2">Daftar Soal</h2>

        @if($exam->soals->count())
        <form action="{{ route('admin.soal.bulkDelete') }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus soal yang dipilih?')">
            @csrf
            <input type="hidden" name="ujian_id" value="{{ $exam->id }}">

            <div class="mb-4">
                <label class="inline-flex items-center">
                    <input type="checkbox" onclick="toggleSelectAll(this)" class="mr-2">
                    Pilih Semua
                </label>
            </div>

            <ol class="list-decimal ml-5 space-y-3">
                @foreach($exam->soals as $soal)
                    <li>
                        <label class="block">
                            <span class="font-semibold">{{ $soal->pertanyaan }}</span>
                            <input type="checkbox" name="soal_ids[]" value="{{ $soal->id }}" class="ml-2">
                        </label>
                        <ul class="ml-6 list-disc text-sm">
                            <li><strong>A:</strong> {{ $soal->opsi_a }}</li>
                            <li><strong>B:</strong> {{ $soal->opsi_b }}</li>
                            <li><strong>C:</strong> {{ $soal->opsi_c }}</li>
                            <li><strong>D:</strong> {{ $soal->opsi_d }}</li>
                        </ul>
                        <p class="text-green-600 text-sm mt-1">Jawaban Benar: <strong>{{ strtoupper($soal->jawaban_benar) }}</strong></p>
                    </li>
                @endforeach
            </ol>

            <div class="mt-4">
                <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded">
                    🗑 Hapus Soal Terpilih
                </button>
            </div>
        </form>
        @else
            <p class="text-sm text-gray-500">Belum ada soal untuk ujian ini.</p>
        @endif

        <div class="mt-6">
            <a href="{{ route('admin.dashboard') }}" class="text-blue-500 hover:underline">← Kembali ke Dashboard</a>
        </div>
    </div>
</body>
</html>
