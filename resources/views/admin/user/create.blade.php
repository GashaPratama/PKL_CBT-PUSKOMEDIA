<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah User</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-xl mx-auto bg-white p-6 shadow rounded">
        <h2 class="text-xl font-bold mb-4">Tambah Pengguna Baru</h2>

        {{-- Tampilkan error validasi --}}
        @if($errors->any())
            <div class="mb-4 p-3 bg-red-100 text-red-600 rounded">
                <ul class="list-disc pl-5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form Tambah User Manual --}}
        <form method="POST" action="{{ route('admin.user.store') }}">
            @csrf

            <div class="mb-4">
                <label class="block mb-1 font-medium">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" class="w-full border p-2 rounded" value="{{ old('nama_lengkap') }}" required>
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium">Email</label>
                <input type="email" name="email" class="w-full border p-2 rounded" value="{{ old('email') }}" required>
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium">Password</label>
                <input type="password" name="password" class="w-full border p-2 rounded" required>
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium">No Telpon</label>
                <input type="text" name="no_telpon" class="w-full border p-2 rounded" value="{{ old('no_telpon') }}">
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="w-full border p-2 rounded" required>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>

            <div class="mb-4">
                <label class="block mb-1 font-medium">Role</label>
                <select name="role" class="w-full border p-2 rounded" required>
                    <option value="" disabled selected>Pilih Role</option>
                    <option value="siswa" {{ old('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Simpan
            </button>
        </form>

        {{-- Divider --}}
        <div class="my-6 border-t"></div>

        {{-- Form Upload Excel --}}
        <h3 class="text-lg font-bold mb-3">Import Pengguna dari Excel</h3>
        <form method="POST" action="{{ route('admin.user.import') }}" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block mb-1 font-medium">Upload File (.xlsx)</label>
                <input type="file" name="file" accept=".xlsx,.xls" class="w-full border p-2 rounded" required>
            </div>

            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Import Excel
            </button>

            {{-- Optional: Link Download Template --}}
            <a href="{{ asset('files/template_user.xlsx') }}" download
               class="text-sm text-blue-600 underline ml-4">Download Template</a>
        </form>
    </div>
</body>
</html>
