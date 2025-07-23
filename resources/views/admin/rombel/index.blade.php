<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manajemen Rombel</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

  <div class="max-w-3xl mx-auto bg-white p-6 rounded shadow">
    <div class="flex justify-between items-center mb-4">
      <h2 class="text-2xl font-bold">Data Rombongan Belajar</h2>
      <a href="{{ route('admin.dashboard') }}" class="text-sm bg-gray-200 hover:bg-gray-300 text-gray-800 px-3 py-1 rounded">
        ← Kembali ke Dashboard
      </a>
    </div>

    @if(session('success'))
      <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
        {{ session('success') }}
      </div>
    @endif

    <form method="POST" action="{{ route('admin.rombel.store') }}" class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
      @csrf
      <select name="kelas_id" required class="border p-2 rounded w-full">
        <option value="" disabled selected>Pilih Kelas</option>
        @foreach($kelas as $k)
          <option value="{{ $k->id }}">{{ $k->nama_kelas }}</option>
        @endforeach
      </select>
      <input type="text" name="nama_kelompok" class="border p-2 rounded w-full" placeholder="Kelompok (cth: A)" required>
      <button class="bg-blue-600 text-white px-4 py-2 rounded w-full">Tambah</button>
    </form>

    <table class="w-full text-left border text-sm">
      <thead class="bg-gray-100">
        <tr>
          <th class="border px-2 py-1">#</th>
          <th class="border px-2 py-1">Kelas</th>
          <th class="border px-2 py-1">Kelompok</th>
          <th class="border px-2 py-1">Aksi</th>
        </tr>
      </thead>
      <tbody>
        @foreach($rombels as $i => $r)
        <tr>
          <td class="border px-2 py-1">{{ $i + 1 }}</td>
          <td class="border px-2 py-1">{{ $r->kelas->nama_kelas }}</td>
          <td class="border px-2 py-1">{{ $r->nama_kelompok }}</td>
          <td class="border px-2 py-1">
            <form action="{{ route('admin.rombel.destroy', $r->id) }}" method="POST" onsubmit="return confirm('Yakin hapus rombel ini?');">
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
