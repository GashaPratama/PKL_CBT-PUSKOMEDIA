<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $title ?? 'Dashboard Admin - CBT' }}</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head> 
<body class="bg-gray-100 min-h-screen flex flex-col font-sans">

  <!-- Navbar -->
  <nav class="bg-blue-600 text-white py-4 shadow">
    <div class="max-w-7xl mx-auto w-full px-4">
      <div class="flex justify-between items-center w-full">
        <h1 class="text-base sm:text-lg font-semibold">
          Selamat Datang, {{ auth()->user()->nama_lengkap ?? 'Admin' }}
        </h1>
        <form action="{{ route('logout') }}" method="POST" onsubmit="return confirm('Yakin ingin logout?');">
          @csrf
          <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded shadow text-sm">
            🔒 Logout
          </button>
        </form>
      </div>
    </div>
  </nav>

  <div class="flex flex-1 overflow-hidden">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-xl border-r p-4 hidden md:block">
        <nav class="space-y-2">
          `
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-100 text-blue-700 font-medium transition">
            🏠 Dashboard
            </a>
            <a href="{{ route('admin.user.show') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-100 text-blue-700 font-medium transition">
            👁 Siswa
            </a>
            <a href="{{ route('admin.ujian.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-100 text-blue-700 font-medium transition">
            📋 Ujian
            </a>
            
            <a href="{{ route('admin.kelas.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-100 text-blue-700 font-medium transition">
            📘 Manajemen Kelas
            </a>
            <a href="{{ route('admin.rombel.index') }}" class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-blue-100 text-blue-700 font-medium transition">
            👥 Manajemen Rombel
            </a>
        </nav>
    </aside>


    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto p-4 sm:p-6 bg-gray-100">
      {{ $slot }}
    </main>
  </div>
</body>
</html>
