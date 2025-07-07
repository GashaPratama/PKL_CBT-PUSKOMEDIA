<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Peserta</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">
    <div class="max-w-6xl mx-auto bg-white shadow-md rounded p-6">
        <h2 class="text-2xl font-bold mb-6">Daftar Peserta</h2>

        @if(session('success'))
            <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full border text-left">
            <thead class="bg-gray-200">
                <tr>
                    <th class="p-2 border">#</th>
                    <th class="p-2 border">Nama Lengkap</th>
                    <th class="p-2 border">Email</th>
                    <th class="p-2 border">No Telpon</th>
                    <th class="p-2 border">Jenis Kelamin</th>
                    <th class="p-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $index => $user)
                    <tr class="border-t">
                        <td class="p-2">{{ $index + 1 }}</td>
                        <td class="p-2">{{ $user->nama_lengkap }}</td>
                        <td class="p-2">{{ $user->email }}</td>
                        <td class="p-2">{{ $user->no_telpon }}</td>
                        <td class="p-2">{{ $user->jenis_kelamin }}</td>
                        <td class="p-2 space-x-2">

                            {{-- Reset Password --}}
                            <form action="{{ route('admin.user.reset', $user->id_user) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit"
                                    onclick="return confirm('Reset password untuk {{ $user->nama_lengkap }} ke default?')"
                                    class="text-blue-600 hover:underline text-sm">
                                    🔁 Reset
                                </button>
                            </form>

                            {{-- Hapus User --}}
                            <form action="{{ route('admin.user.destroy', $user->id_user) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                    onclick="return confirm('Yakin ingin menghapus {{ $user->nama_lengkap }}?')"
                                    class="text-red-600 hover:underline text-sm">
                                    🗑 Hapus
                                </button>
                            </form>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
