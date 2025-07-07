<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nilai Ujian</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">
    <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Nilai Peserta: {{ $exam->nama }}</h1>

        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 border">#</th>
                    <th class="px-4 py-2 border">Nama Peserta</th>
                    <th class="px-4 py-2 border">Email</th>
                    <th class="px-4 py-2 border">Skor</th>
                </tr>
            </thead>
            <tbody>
                @forelse($exam->hasilUjian as $index => $hasil)
                    <tr>
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

        <div class="mt-6">
            <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">← Kembali ke Dashboard</a>
        </div>
    </div>
</body>
</html>
