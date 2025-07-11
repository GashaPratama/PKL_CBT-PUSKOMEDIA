<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nilai Ujian</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-4 sm:p-6">

    <div class="max-w-4xl mx-auto bg-white p-6 sm:p-8 rounded-xl shadow">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Nilai Peserta: {{ $exam->nama }}</h1>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200 text-sm sm:text-base">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="px-4 py-2 border text-left">#</th>
                        <th class="px-4 py-2 border text-left">Nama Peserta</th>
                        <th class="px-4 py-2 border text-left">Email</th>
                        <th class="px-4 py-2 border text-center">Skor</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($exam->hasilUjian as $index => $hasil)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 border">{{ $hasil->user->nama_lengkap }}</td>
                            <td class="px-4 py-2 border">{{ $hasil->user->email }}</td>
                            <td class="px-4 py-2 border text-center">{{ $hasil->skor }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center p-4 text-gray-500">Belum ada nilai peserta.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline text-sm">
                ← Kembali ke Dashboard
            </a>
        </div>
    </div>

</body>
</html>
