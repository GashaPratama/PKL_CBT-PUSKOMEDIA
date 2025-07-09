<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Hasil Simulasi Ujian</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6 font-sans">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold mb-4">🧪 Hasil Simulasi Ujian</h2>

        <div class="mb-4">
            <p><strong>Nama Ujian:</strong> {{ $exam->nama }}</p>
            <p><strong>Jumlah Soal:</strong> {{ $totalSoal }}</p>
            <p><strong>Jawaban Benar:</strong> {{ $jumlahBenar }}</p>
            <p><strong>Skor:</strong> {{ $skor }}%</p>
        </div>

        <hr class="my-4">

        <h3 class="text-xl font-semibold mb-2">Review Jawaban</h3>

        <div class="space-y-4">
            @foreach ($hasil as $index => $item)
                <div class="p-4 rounded border {{ $item['benar'] ? 'bg-green-50 border-green-300' : 'bg-red-50 border-red-300' }}">
                    <h4 class="font-semibold mb-1">Soal {{ $index + 1 }}:</h4>
                    <p class="mb-2">{{ $item['pertanyaan'] }}</p>
                    <ul class="mb-2 list-disc list-inside">
                        <li>A. {{ $item['opsi_a'] }}</li>
                        <li>B. {{ $item['opsi_b'] }}</li>
                        <li>C. {{ $item['opsi_c'] }}</li>
                        <li>D. {{ $item['opsi_d'] }}</li>
                    </ul>
                    <p><strong>Jawaban Anda:</strong> 
                        <span class="{{ $item['benar'] ? 'text-green-600' : 'text-red-600' }}">
                            {{ $item['jawaban_user'] ?? 'Tidak dijawab' }}
                        </span>
                    </p>
                    <p><strong>Jawaban Benar:</strong> <span class="text-green-700">{{ $item['jawaban_benar'] }}</span></p>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            <a href="{{ route('admin.dashboard') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                ← Kembali ke Dashboard
            </a>
        </div>
    </div>
</body>
</html>
