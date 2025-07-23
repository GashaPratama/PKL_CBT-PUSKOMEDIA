<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manajemen Kelas</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

  <div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">

    <div class="flex justify-between items-center mb-4">
      <h2 class="text-2xl font-bold">Data Kelas</h2>
      <a href="{{ route('admin.dashboard') }}" class="text-sm bg-gray-200 hover:bg-gray-300 text-gray-800 px-3 py-1 rounded">
        ← Kembali ke Dashboard
      </a>
    </div>

    @if(session('success'))
      <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
        {{ session('success') }}
      </div>
    @endif

    <form method="POST" action="{{ route('admin.kelas.store') }}" class="flex gap-2 mb-6">
      @csrf
      <input type="text" name="nama_kelas" class="border p-2 rounded w-full" placeholder="Nama kelas (cth: 10)" required>
      <button class="bg-blue-600 text-white px-4 py-2 rounded">Tambah</button>
    </form>

    <table class="w-full text-left border">
      <thead class="bg-gray-100">
        <tr>
          <th class="border px-2 py-1">#</th>
          <th class="border px-2 py-1">Nama Kelas</th>
          <th class="border px-2 py-1">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($data as $i => $k)
        <tr>
          <td class="border px-2 py-1">{{ $i + 1 }}</td>
          <td class="border px-2 py-1">{{ $k->nama_kelas }}</td>
          <td class="border px-2 py-1">
            <form action="{{ route('admin.kelas.destroy', $k->id) }}" method="POST" onsubmit="return confirm('Yakin hapus kelas ini?');">
              @csrf @method('DELETE')
              <button class="text-red-600 hover:underline">Hapus</button>
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>

</body>
</html>
