<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Peserta</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center px-4 py-10">

    <div class="w-full max-w-xl bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-6 text-gray-800 text-center">✏️ Edit Data Peserta</h1>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <strong>Terjadi kesalahan!</strong>
                <ul class="mt-1 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.user.update', $user->id_user) }}">
            @csrf
            @method('PUT')

            <!-- Nama Lengkap -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $user->nama_lengkap) }}"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-400">
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-400">
            </div>

            <!-- No Telpon -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">No Telepon</label>
                <input type="text" name="no_telpon" value="{{ old('no_telpon', $user->no_telpon) }}"
                       class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-400">
            </div>

            <div class="flex justify-between items-center">
                <a href="{{ route('admin.user.show') }}"
                   class="text-sm text-gray-600 hover:underline">
                    ← Kembali
                </a>
                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded shadow text-sm">
                    💾 Simpan Perubahan
                </button>
            </div>
        </form>
    </div>

</body>
</html>
