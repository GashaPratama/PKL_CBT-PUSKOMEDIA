<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Ujian</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-4 sm:p-6">

    <div class="max-w-2xl mx-auto bg-white shadow-md rounded-xl p-6 sm:p-8">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Edit Ujian</h2>

        {{-- FORM UPDATE UJIAN --}}
        <form method="POST" action="{{ route('admin.ujian.update', $exam->id) }}" class="space-y-4 mb-8">
            @csrf
            @method('PUT')

            <div>
                <label class="block font-semibold mb-1 text-sm">Nama Ujian</label>
                <input type="text" name="nama" class="w-full border rounded p-2" value="{{ $exam->nama }}" required>
            </div>

            <div>
                <label class="block font-semibold mb-1 text-sm">Tanggal</label>
                <input type="date" name="tanggal" class="w-full border rounded p-2" value="{{ $exam->tanggal }}" required>
            </div>

            <div>
                <label class="block font-semibold mb-1 text-sm">Deskripsi</label>
                <textarea name="deskripsi" class="w-full border rounded p-2">{{ $exam->deskripsi }}</textarea>
            </div>

            <div>
                <label class="block font-semibold mb-1 text-sm">Jumlah Peserta</label>
                <input type="number" name="jumlah_peserta" class="w-full border rounded p-2" value="{{ $exam->jumlah_peserta }}" required>
            </div>

            <div>
                <label class="block font-semibold mb-1 text-sm">Jumlah Percobaan</label>
                <input type="number" name="jumlah_percobaan" class="w-full border rounded p-2" min="1" value="{{ old('jumlah_percobaan', 1) }}" required>
            </div>

            <div>
                <label class="block font-semibold mb-1 text-sm">Durasi Ujian (menit)</label>
                <input type="number" name="durasi" class="w-full border rounded p-2" min="1" value="{{ old('durasi', 60) }}" required>
            </div>

            <div>
                <label class="block font-semibold mb-1 text-sm">Waktu Mulai</label>
                <input type="datetime-local" name="waktu_mulai" class="w-full border rounded p-2"
                    value="{{ old('waktu_mulai', $exam->waktu_mulai ? \Carbon\Carbon::parse($exam->waktu_mulai)->format('Y-m-d\TH:i') : '') }}">
            </div>

            <div>
                <label class="block font-semibold mb-1 text-sm">Waktu Selesai</label>
                <input type="datetime-local" name="waktu_selesai" class="w-full border rounded p-2"
                    value="{{ old('waktu_selesai', $exam->waktu_selesai ? \Carbon\Carbon::parse($exam->waktu_selesai)->format('Y-m-d\TH:i') : '') }}">
            </div>

            <div class="pt-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Perbarui
                </button>
            </div>
        </form>
        {{-- END FORM UPDATE UJIAN --}}

        <hr class="my-6">

        {{-- FORM IMPORT SOAL --}}
        <h3 class="text-xl font-bold mb-4 text-gray-800">Import Soal dari Excel</h3>
        <form action="{{ route('admin.soal.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <input type="hidden" name="ujian_id" value="{{ $exam->id }}">

            <div>
                <label class="block font-semibold mb-1 text-sm">File Excel</label>
                <input type="file" name="file" accept=".xlsx,.xls" class="w-full border rounded p-2" required>
            </div>

            <div>
                <button type="submit" class="bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded">
                    Upload & Import Soal
                </button>
            </div>
        </form>
        {{-- END FORM IMPORT --}}

        <div class="mt-6">
            <a href="{{ asset('files/template_soal.xlsx') }}"
               class="inline-block bg-gray-200 hover:bg-gray-300 text-sm text-black px-4 py-2 rounded"
               download>
                📥 Download Template Excel
            </a>
        </div>
    </div>

</body>
</html>
