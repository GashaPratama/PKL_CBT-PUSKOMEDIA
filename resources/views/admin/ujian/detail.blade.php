<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Ujian</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
    <div class="max-w-3xl mx-auto bg-white shadow-md rounded p-6">
        <h1 class="text-2xl font-semibold mb-4">Detail Ujian</h1>

        <!-- Info Ujian -->
        <div class="mb-4">
            <p><strong>Nama Ujian:</strong> {{ $exam->nama }}</p>
            <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($exam->tanggal)->translatedFormat('d F Y') }}</p>
            <p><strong>Jumlah Peserta:</strong> {{ $exam->jumlah_peserta }}</p>
            <p><strong>Deskripsi:</strong> {{ $exam->deskripsi }}</p>
        </div>

        <!-- Daftar Soal -->
        <hr class="my-6">
        <h2 class="text-xl font-semibold mb-2">Daftar Soal</h2>

        @if($exam->soals->count())
            <ol class="list-decimal ml-5 space-y-3">
                @foreach($exam->soals as $soal)
                    <li>
                        <p class="font-semibold">{{ $soal->pertanyaan }}</p>
                        <ul class="ml-4 list-disc text-sm">
                            <li><strong>A:</strong> {{ $soal->opsi_a }}</li>
                            <li><strong>B:</strong> {{ $soal->opsi_b }}</li>
                            <li><strong>C:</strong> {{ $soal->opsi_c }}</li>
                            <li><strong>D:</strong> {{ $soal->opsi_d }}</li>
                        </ul>
                        <p class="text-green-600 text-sm mt-1">Jawaban Benar: <strong>{{ strtoupper($soal->jawaban_benar) }}</strong></p>
                    </li>
                @endforeach
            </ol>
        @else
            <p class="text-sm text-gray-500">Belum ada soal untuk ujian ini.</p>
        @endif

        <div class="mt-6">
            <a href="{{ route('admin.dashboard') }}" class="text-blue-500 hover:underline">← Kembali ke Dashboard</a>
        </div>
    </div>
</body>
</html>
