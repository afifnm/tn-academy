  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <div class="p-6">
    <h1 class="text-2xl font-bold text-blue-700">Dashboard Raport Akademik TN Malang</h1>
    <p class="text-gray-600">Selamat datang di sistem raport akademik</p>

    <!-- Statistik Utama -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
      <div class="bg-white shadow rounded-xl p-5">
        <div class="flex items-center">
          <i data-lucide="users" class="w-10 h-10 text-blue-500"></i>
          <div class="ml-auto text-right">
            <h3 class="text-3xl font-bold">1.245</h3>
            <p class="text-gray-500">Jumlah Siswa</p>
          </div>
        </div>
      </div>
      <div class="bg-white shadow rounded-xl p-5">
        <div class="flex items-center">
          <i data-lucide="user" class="w-10 h-10 text-green-500"></i>
          <div class="ml-auto text-right">
            <h3 class="text-3xl font-bold">86</h3>
            <p class="text-gray-500">Jumlah Guru</p>
          </div>
        </div>
      </div>
      <div class="bg-white shadow rounded-xl p-5">
        <div class="flex items-center">
          <i data-lucide="book" class="w-10 h-10 text-purple-500"></i>
          <div class="ml-auto text-right">
            <h3 class="text-3xl font-bold">32</h3>
            <p class="text-gray-500">Jumlah Kelas</p>
          </div>
        </div>
      </div>
      <div class="bg-white shadow rounded-xl p-5">
        <div class="flex items-center">
          <i data-lucide="file-text" class="w-10 h-10 text-orange-500"></i>
          <div class="ml-auto text-right">
            <h3 class="text-3xl font-bold">15</h3>
            <p class="text-gray-500">Mata Pelajaran</p>
          </div>
        </div>
      </div>
    </div>

    <!-- Statistik Nilai -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
      <div class="bg-white shadow rounded-xl p-5">
        <p class="text-gray-500">Rata-rata Nilai</p>
        <h3 class="text-3xl font-bold text-blue-700">82.4</h3>
      </div>
      <div class="bg-white shadow rounded-xl p-5">
        <p class="text-gray-500">Top Student</p>
        <h3 class="text-lg font-bold">Aulia Rahman (97)</h3>
      </div>
      <div class="bg-white shadow rounded-xl p-5">
        <p class="text-gray-500">Nilai Terendah</p>
        <h3 class="text-lg font-bold">Budi Santoso (55)</h3>
      </div>
      <div class="bg-white shadow rounded-xl p-5">
        <p class="text-gray-500">Kenaikan Semester</p>
        <h3 class="text-lg font-bold text-green-600">+4.5%</h3>
      </div>
    </div>

    <!-- Grafik Dummy -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
      <div class="bg-white shadow rounded-xl p-5 h-60 flex items-center justify-center">
        <p class="text-gray-500">[ Grafik Distribusi Nilai ]</p>
      </div>
      <div class="bg-white shadow rounded-xl p-5 h-60 flex items-center justify-center">
        <p class="text-gray-500">[ Grafik Kehadiran Siswa ]</p>
      </div>
      <div class="bg-white shadow rounded-xl p-5 h-60 flex items-center justify-center">
        <p class="text-gray-500">[ Grafik Perkembangan Nilai ]</p>
      </div>
    </div>

    <!-- Ranking & Informasi -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
      <!-- Ranking -->
      <div class="bg-white shadow rounded-xl p-5">
        <h3 class="text-lg font-bold text-blue-700 mb-3">Top 5 Siswa Kelas XII</h3>
        <ol class="list-decimal list-inside text-gray-700 space-y-1">
          <li>Aulia Rahman - 97</li>
          <li>Siti Aminah - 95</li>
          <li>Rizky Hidayat - 94</li>
          <li>Dewi Lestari - 93</li>
          <li>Budi Santoso - 92</li>
        </ol>
      </div>

      <!-- Pengumuman -->
      <div class="bg-white shadow rounded-xl p-5">
        <h3 class="text-lg font-bold text-blue-700 mb-3">Pengumuman Terbaru</h3>
        <ul class="list-disc list-inside text-gray-700 space-y-1">
          <li>Deadline input nilai: 25 September 2025</li>
          <li>Rapat guru wali kelas: 28 September 2025</li>
          <li>Pembagian rapor: 5 Oktober 2025</li>
        </ul>
      </div>
    </div>

    <!-- Agenda Akademik -->
    <div class="bg-white shadow rounded-xl p-5 mt-6">
      <h3 class="text-lg font-bold text-blue-700 mb-3">Agenda Akademik</h3>
      <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="p-4 bg-blue-50 rounded-lg">
          <p class="text-gray-500">Ujian Tengah Semester</p>
          <h4 class="font-bold text-gray-800">10 - 15 Oktober</h4>
        </div>
        <div class="p-4 bg-blue-50 rounded-lg">
          <p class="text-gray-500">Ujian Akhir Semester</p>
          <h4 class="font-bold text-gray-800">5 - 10 Desember</h4>
        </div>
        <div class="p-4 bg-blue-50 rounded-lg">
          <p class="text-gray-500">Pembagian Rapor</p>
          <h4 class="font-bold text-gray-800">20 Desember</h4>
        </div>
      </div>
    </div>
  </div>

  <script>
    lucide.createIcons();
  </script>