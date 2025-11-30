<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/lucide@latest"></script>

<div class="p-6 bg-gray-100 min-h-screen">
  <!-- Header -->
  <div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">📊 Dashboard E-Tarnus Malang</h1>
    <p class="text-gray-600">Selamat datang di E-Tarnus Malang</p>
  </div>

  <!-- Pencarian Siswa -->
<!-- Pencarian Siswa -->
<div class="mb-6 relative w-full">
  <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
    <i data-lucide="search" class="w-5 h-5"></i>
  </span>
  <input 
    type="text" 
    id="searchSiswa" 
    placeholder="Cari siswa berdasarkan nama atau NISN..." 
    class="w-full pl-10 pr-4 py-3 border border-gray-200 rounded-2xl shadow-sm 
           focus:ring-2 focus:ring-blue-500 focus:border-blue-500 
           text-gray-700 placeholder-gray-400 text-base"
  >

  <!-- Hasil AJAX -->
  <ul id="resultSiswa" 
      class="hidden absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-xl shadow-lg max-h-60 overflow-y-auto">
  </ul>
</div>



  <!-- Statistik Utama -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    <div class="bg-white rounded-2xl shadow p-6 hover:shadow-md transition">
      <div class="flex items-center justify-between">
        <div class="p-3 rounded-xl bg-blue-100 text-blue-600">
          <i data-lucide="users" class="w-6 h-6"></i>
        </div>
        <div class="text-right">
          <h3 class="text-2xl font-bold">1.245</h3>
          <p class="text-sm text-gray-500">Jumlah Siswa</p>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-2xl shadow p-6 hover:shadow-md transition">
      <div class="flex items-center justify-between">
        <div class="p-3 rounded-xl bg-green-100 text-green-600">
          <i data-lucide="user" class="w-6 h-6"></i>
        </div>
        <div class="text-right">
          <h3 class="text-2xl font-bold">86</h3>
          <p class="text-sm text-gray-500">Jumlah Guru</p>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-2xl shadow p-6 hover:shadow-md transition">
      <div class="flex items-center justify-between">
        <div class="p-3 rounded-xl bg-purple-100 text-purple-600">
          <i data-lucide="book" class="w-6 h-6"></i>
        </div>
        <div class="text-right">
          <h3 class="text-2xl font-bold">32</h3>
          <p class="text-sm text-gray-500">Jumlah Kelas</p>
        </div>
      </div>
    </div>

    <div class="bg-white rounded-2xl shadow p-6 hover:shadow-md transition">
      <div class="flex items-center justify-between">
        <div class="p-3 rounded-xl bg-orange-100 text-orange-600">
          <i data-lucide="file-text" class="w-6 h-6"></i>
        </div>
        <div class="text-right">
          <h3 class="text-2xl font-bold">15</h3>
          <p class="text-sm text-gray-500">Mata Pelajaran</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Statistik Nilai -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-6">
    <div class="bg-white rounded-2xl shadow p-6 hover:shadow-md transition">
      <p class="text-sm text-gray-500">Rata-rata Nilai</p>
      <h3 class="text-3xl font-bold text-blue-600">82.4</h3>
    </div>
    <div class="bg-white rounded-2xl shadow p-6 hover:shadow-md transition">
      <p class="text-sm text-gray-500">Top Student</p>
      <h3 class="text-lg font-semibold text-gray-800">Aulia Rahman (97)</h3>
    </div>
    <div class="bg-white rounded-2xl shadow p-6 hover:shadow-md transition">
      <p class="text-sm text-gray-500">Nilai Terendah</p>
      <h3 class="text-lg font-semibold text-gray-800">Budi Santoso (55)</h3>
    </div>
    <div class="bg-white rounded-2xl shadow p-6 hover:shadow-md transition">
      <p class="text-sm text-gray-500">Kenaikan Semester</p>
      <h3 class="text-lg font-semibold text-green-600">+4.5%</h3>
    </div>
  </div>

  <!-- Grafik Dummy -->
  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mt-6">
    <div class="bg-white rounded-2xl shadow p-6 h-60 flex items-center justify-center text-gray-400">
      [ Grafik Distribusi Nilai ]
    </div>
    <div class="bg-white rounded-2xl shadow p-6 h-60 flex items-center justify-center text-gray-400">
      [ Grafik Kehadiran Siswa ]
    </div>
    <div class="bg-white rounded-2xl shadow p-6 h-60 flex items-center justify-center text-gray-400">
      [ Grafik Perkembangan Nilai ]
    </div>
  </div>

  <!-- Ranking & Pengumuman -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
    <div class="bg-white rounded-2xl shadow p-6">
      <h3 class="text-lg font-bold text-blue-700 mb-3">🏆 Top 5 Siswa Kelas XII</h3>
      <ol class="list-decimal list-inside text-gray-700 space-y-1">
        <li>Aulia Rahman - 97</li>
        <li>Siti Aminah - 95</li>
        <li>Rizky Hidayat - 94</li>
        <li>Dewi Lestari - 93</li>
        <li>Budi Santoso - 92</li>
      </ol>
    </div>

    <div class="bg-white rounded-2xl shadow p-6">
      <h3 class="text-lg font-bold text-blue-700 mb-3">📢 Pengumuman Terbaru</h3>
      <ul class="list-disc list-inside text-gray-700 space-y-1">
        <li>Deadline input nilai: 25 September 2025</li>
        <li>Rapat guru wali kelas: 28 September 2025</li>
        <li>Pembagian rapor: 5 Oktober 2025</li>
      </ul>
    </div>
  </div>

  <!-- Agenda Akademik -->
  <div class="bg-white rounded-2xl shadow p-6 mt-6">
    <h3 class="text-lg font-bold text-blue-700 mb-3">📅 Agenda Akademik</h3>
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
      <div class="p-4 bg-blue-50 rounded-xl text-center">
        <p class="text-sm text-gray-500">Ujian Tengah Semester</p>
        <h4 class="font-semibold text-gray-800">10 - 15 Oktober</h4>
      </div>
      <div class="p-4 bg-blue-50 rounded-xl text-center">
        <p class="text-sm text-gray-500">Ujian Akhir Semester</p>
        <h4 class="font-semibold text-gray-800">5 - 10 Desember</h4>
      </div>
      <div class="p-4 bg-blue-50 rounded-xl text-center">
        <p class="text-sm text-gray-500">Pembagian Rapor</p>
        <h4 class="font-semibold text-gray-800">20 Desember</h4>
      </div>
    </div>
  </div>
</div>

<script>
  lucide.createIcons();
</script>

<script>
  $(document).ready(function() {
    $("#searchSiswa").on("keyup", function() {
      let query = $(this).val();
        // console.log("Ketik:", query); 

      if(query.length > 2) { // mulai cari setelah ketik >= 3 huruf
        jQuery.ajax({
          url: "<?= base_url('home/search') ?>",
          type: "GET",
          data: { q: query },
          success: function(data) {
            let siswa = JSON.parse(data);
            let list = "";
            // console.log("Response:", data); 

            if(siswa.length > 0){
              siswa.forEach(function(item) {
               list += `<li 
                class="px-4 py-2 hover:bg-gray-100 cursor-pointer"
                onclick="window.location.href='<?= base_url('admin/siswa/detail/') ?>${item.id_siswa}'">
                ${item.nama} (${item.nisn})
              </li>`;

              });
            } else {
              list = `<li class="px-4 py-2 text-gray-400">Tidak ditemukan</li>`;
            }

            $("#resultSiswa").html(list).removeClass("hidden");
          },
          error: function(err) {
            console.error("AJAX Error:", err);
          }
        });
      } else {
        $("#resultSiswa").addClass("hidden");
      }
    });
  });
</script>
