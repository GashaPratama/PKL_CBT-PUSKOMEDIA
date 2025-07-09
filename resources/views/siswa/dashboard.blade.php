<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Siswa</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6 font-sans">
    <div class="max-w-5xl mx-auto bg-white p-6 rounded shadow">
        <h2 class="text-2xl font-bold mb-6">📚 Dashboard Siswa</h2>

        <table class="w-full border text-left">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-2 border">#</th>
                    <th class="p-2 border">Nama Ujian</th>
                    <th class="p-2 border">Tanggal</th>
                    <th class="p-2 border">Durasi</th>
                    <th class="p-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($ujians as $index => $ujian)
                <tr class="border-t">
                    <td class="p-2">{{ $index + 1 }}</td>
                    <td class="p-2">{{ $ujian->nama }}</td>
                    <td class="p-2">{{ \Carbon\Carbon::parse($ujian->tanggal)->translatedFormat('d F Y') }}</td>
                    <td class="p-2">{{ $ujian->durasi }} menit</td>
                    <td class="p-2">
                        <a href="{{ route('siswa.ujian', $ujian->id) }}" class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 text-sm">📥 Unduh & Kerjakan</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
