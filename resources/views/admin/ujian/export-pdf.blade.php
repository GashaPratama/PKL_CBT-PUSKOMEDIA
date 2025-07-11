<!DOCTYPE html>
<html>
<head>
    <title>Hasil Ujian PDF</title>
    <style>
        body { font-family: DejaVu Sans; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
    </style>
</head>
<body>
    <h2>Hasil Ujian: {{ $ujian->nama }}</h2>
    <p>Tanggal: {{ \Carbon\Carbon::parse($ujian->tanggal)->format('d M Y') }}</p>

    <table>
        <thead>
            <tr>
                <th>Nama Peserta</th>
                <th>Email</th>
                <th>Nilai</th>
                <th>Waktu Kirim</th>
            </tr>
        </thead>
        <tbody>
            @foreach($ujian->hasilUjian as $hasil)
            <tr>
                <td>{{ $hasil->user?->nama_lengkap ?? '-' }}</td>
                <td>{{ $hasil->user?->email ?? '-' }}</td>
                <td style="text-align: center">{{ $hasil->nilai ?? '-' }}</td>
                <td>{{ $hasil->created_at ? $hasil->created_at->format('d M Y H:i') : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
