<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Data Peserta PDF</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
    </style>
</head>
<body>
    <h2>Daftar Peserta</h2>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Lengkap</th>
                <th>Email</th>
                <th>No Telpon</th>
                <th>Jenis Kelamin</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $i => $user)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $user->nama_lengkap }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ $user->no_telpon }}</td>
                <td>{{ $user->jenis_kelamin }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
