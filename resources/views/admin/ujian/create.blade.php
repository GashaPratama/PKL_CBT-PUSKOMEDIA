<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Ujian</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-4 sm:p-6">

    <div class="max-w-2xl mx-auto bg-white shadow-md rounded-xl p-6 sm:p-8">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Tambah Ujian Baru</h2>

        @if ($errors->any())
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 p-4 rounded-lg text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.ujian.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block font-semibold mb-1 text-sm">Nama Ujian</label>
                <input type="text" name="nama" class="w-full border p-2 rounded" required>
            </div>

            <div>
                <label class="block font-semibold mb-1 text-sm">Tanggal</label>
                <input type="date" name="tanggal" class="w-full border p-2 rounded" required>
            </div>

            <div>
                <label class="block font-semibold mb-1 text-sm">Deskripsi (Opsional)</label>
                <textarea name="deskripsi" class="w-full border p-2 rounded resize-y"></textarea>
            </div>

            <div>
                <label class="block font-semibold mb-1 text-sm">Jumlah Peserta</label>
                <input type="number" name="jumlah_peserta" class="w-full border p-2 rounded" min="0" required>
            </div>

            <div>
                <label class="block font-semibold mb-1 text-sm">Jumlah Percobaan</label>
                <input type="number" name="jumlah_percobaan" class="w-full border p-2 rounded" min="1" value="{{ old('jumlah_percobaan', 1) }}" required>
            </div>

            <div>
                <label class="block font-semibold mb-1 text-sm">Durasi Ujian (menit)</label>
                <input type="number" name="durasi" class="w-full border p-2 rounded" min="1" value="{{ old('durasi', 60) }}" required>
            </div>

            <div>
                <label class="block font-semibold mb-1 text-sm">Waktu Mulai</label>
                <input type="datetime-local" name="waktu_mulai" class="w-full border p-2 rounded" value="{{ old('waktu_mulai') }}">
            </div>

            <div>
                <label class="block font-semibold mb-1 text-sm">Waktu Selesai</label>
                <input type="datetime-local" name="waktu_selesai" class="w-full border p-2 rounded" value="{{ old('waktu_selesai') }}">
            </div>

            <div class="pt-2">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                    Simpan
                </button>
            </div>
        </form>
    </div>

</body>
</html>
