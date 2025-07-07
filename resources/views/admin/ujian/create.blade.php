<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Ujian</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
    <div class="max-w-2xl mx-auto bg-white shadow-md rounded p-6">
        <h2 class="text-2xl font-bold mb-6">Tambah Ujian Baru</h2>

        @if ($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 p-3 rounded">
                <ul class="text-sm list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.ujian.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block font-semibold mb-1">Nama Ujian</label>
                <input type="text" name="nama" class="w-full border rounded p-2" required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Tanggal</label>
                <input type="date" name="tanggal" class="w-full border rounded p-2" required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Deskripsi (Opsional)</label>
                <textarea name="deskripsi" class="w-full border rounded p-2"></textarea>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Jumlah Peserta</label>
                <input type="number" name="jumlah_peserta" class="w-full border rounded p-2" min="0" required>
            </div>

            <div class="mb-4">
            <div class="mb-4">
                <label class="block font-semibold mb-1">Jumlah Percobaan</label>
                <input type="number" name="jumlah_percobaan" class="w-full border rounded p-2" min="1" value="{{ old('jumlah_percobaan', 1) }}" required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Durasi Ujian (menit)</label>
                <input type="number" name="durasi" class="w-full border rounded p-2" min="1" value="{{ old('durasi', 60) }}" required>
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Waktu Mulai</label>
                <input type="datetime-local" name="waktu_mulai" class="w-full border rounded p-2" value="{{ old('waktu_mulai') }}">
            </div>

            <div class="mb-4">
                <label class="block font-semibold mb-1">Waktu Selesai</label>
                <input type="datetime-local" name="waktu_selesai" class="w-full border rounded p-2" value="{{ old('waktu_selesai') }}">
            </div>

            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                Simpan
            </button>
        </form>
    </div>
</body>
</html>
