<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Simulasi Ujian</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-4 sm:p-6 font-sans">

    <div class="w-full max-w-4xl mx-auto bg-white p-4 sm:p-6 rounded-xl shadow-md">
        <h2 class="text-xl sm:text-2xl font-bold mb-4 text-gray-800">🧪 Hasil Simulasi Ujian</h2>

        <!-- Ringkasan Skor -->
        <div class="mb-6 space-y-1 text-sm sm:text-base">
            <p><strong>Nama Ujian:</strong> {{ $exam->nama }}</p>
            <p><strong>Jumlah Soal:</strong> {{ $totalSoal }}</p>
            <p><strong>Jawaban Benar:</strong> {{ $jumlahBenar }}</p>
            <p><strong>Skor:</strong> {{ $skor }}%</p>
        </div>

        <hr class="my-6">

        <!-- Review Jawaban -->
        <h3 class="text-lg sm:text-xl font-semibold mb-4 text-gray-800">Review Jawaban</h3>

        <div class="space-y-4">
            @foreach ($hasil as $index => $item)
                <div class="p-4 rounded-lg border text-sm sm:text-base {{ $item['benar'] ? 'bg-green-50 border-green-300' : 'bg-red-50 border-red-300' }}">
                    <h4 class="font-semibold mb-1">Soal {{ $index + 1 }}:</h4>
                    <p class="mb-2">{{ $item['pertanyaan'] }}</p>
                    <ul class="mb-2 list-disc list-inside text-gray-700">
                        <li><strong>A:</strong> {{ $item['opsi_a'] }}</li>
                        <li><strong>B:</strong> {{ $item['opsi_b'] }}</li>
                        <li><strong>C:</strong> {{ $item['opsi_c'] }}</li>
                        <li><strong>D:</strong> {{ $item['opsi_d'] }}</li>
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

        <div class="mt-8">
            <a href="{{ route('admin.dashboard') }}" class="inline-block bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm sm:text-base">
                ← Kembali ke Dashboard
            </a>
        </div>
    </div>

</body>
</html>
