<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-4 sm:p-6">

    <div class="max-w-2xl mx-auto bg-white p-6 sm:p-8 shadow-md rounded-xl">

        <h2 class="text-2xl font-bold mb-4 text-gray-800">Tambah Pengguna Baru</h2>

        {{-- Tampilkan error validasi --}}
        @if($errors->any())
            <div class="mb-6 p-4 bg-red-100 text-red-600 rounded-lg">
                <ul class="list-disc pl-5 text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Form Tambah User Manual --}}
        <form method="POST" action="{{ route('admin.user.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block mb-1 font-medium text-sm">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" class="w-full border p-2 rounded" value="{{ old('nama_lengkap') }}" required>
            </div>

            <div>
                <label class="block mb-1 font-medium text-sm">Email</label>
                <input type="email" name="email" class="w-full border p-2 rounded" value="{{ old('email') }}" required>
            </div>

            <div>
                <label class="block mb-1 font-medium text-sm">Password</label>
                <input type="password" name="password" class="w-full border p-2 rounded" required>
            </div>

            <div>
                <label class="block mb-1 font-medium text-sm">No Telpon</label>
                <input type="text" name="no_telpon" class="w-full border p-2 rounded" value="{{ old('no_telpon') }}">
            </div>

            <div>
                <label class="block mb-1 font-medium text-sm">Jenis Kelamin</label>
                <select name="jenis_kelamin" class="w-full border p-2 rounded" required>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select>
            </div>

            <div>
                <label class="block mb-1 font-medium text-sm">Role</label>
                <select name="role" class="w-full border p-2 rounded" required>
                    <option value="" disabled selected>Pilih Role</option>
                    <option value="siswa" {{ old('role') == 'siswa' ? 'selected' : '' }}>Siswa</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>

            <div class="pt-2">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                    Simpan
                </button>
            </div>
        </form>

        {{-- Divider --}}
        <div class="my-8 border-t"></div>

        {{-- Form Upload Excel --}}
        <h3 class="text-lg font-bold mb-4 text-gray-800">Import Pengguna dari Excel</h3>
        <form method="POST" action="{{ route('admin.user.import') }}" enctype="multipart/form-data" class="space-y-4">
            @csrf
            <div>
                <label class="block mb-1 font-medium text-sm">Upload File (.xlsx)</label>
                <input type="file" name="file" accept=".xlsx,.xls" class="w-full border p-2 rounded" required>
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center gap-3">
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                    Import Excel
                </button>
                <a href="{{ asset('files/template_user.xlsx') }}" download class="text-sm text-blue-600 underline">
                    Download Template
                </a>
            </div>
        </form>

    </div>

</body>
</html>
