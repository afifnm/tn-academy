<script src="https://cdn.tailwindcss.com"></script>
<script src="https://unpkg.com/lucide@latest"></script>

<div class="p-6 bg-gray-100 min-h-screen">
  <!-- Header -->
  <div class="mb-6">
    <h1 class="text-3xl font-bold text-gray-800">📊 Dashboard E-Tarnus Malang</h1>
    <p class="text-gray-600">Selamat datang <?= $this->session->userdata('nama') ?>, anda login sebagai <?= $this->session->userdata('role') ?></p>
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
    placeholder="Cari siswa berdasarkan nama atau NIS atau NISN..." 
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
          <h3 class="text-2xl font-bold"><?= $this->db->where('status', 'aktif')->count_all_results('enroll') ?></h3>
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
          <h3 class="text-2xl font-bold"><?= $this->db->count_all_results('guru') ?></h3>
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
          <h3 class="text-2xl font-bold"><?= $this->db->count_all_results('kelas') ?></h3>
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
          <h3 class="text-2xl font-bold"><?= $this->db->count_all_results('mapel') ?></h3>
          <p class="text-sm text-gray-500">Mata Pelajaran</p>
        </div>
      </div>
    </div>
  </div>

  <!-- Ranking & Pengumuman -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">
    <div class="bg-white rounded-2xl shadow p-6">
      <h3 class="text-lg font-bold text-blue-700 mb-3">🏆 Top 5 Siswa Kelas X</h3>
      <ol class="list-decimal list-inside text-gray-700 space-y-1">
        -Belum ada data-
      </ol>
    </div>
    <div class="bg-white rounded-2xl shadow p-6">
      <h3 class="text-lg font-bold text-blue-700 mb-3">🏆 Top 5 Siswa Kelas XI</h3>
      <ol class="list-decimal list-inside text-gray-700 space-y-1">
        -Belum ada data-
      </ol>
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
                  ${item.nama} (${item.nis})
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
