<?php 
    // Daftar ekstensi yang diperbolehkan
    $allowedExt = ['jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG'];

    $fotoFile = null;

    foreach ($allowedExt as $ext) {
        $checkFile = $siswa['nis'] . '.' . $ext;
        $checkPath = FCPATH . 'assets/upload/foto_siswa/' . $checkFile;

        if (file_exists($checkPath)) {
            $fotoFile = $checkFile;
            break; // hentikan jika sudah ketemu
        }
    }

    // Jika ditemukan, set URL foto
    if ($fotoFile) {
        $fotoURL = base_url('assets/upload/foto_siswa/' . $fotoFile);
    } else {
        // default jika tidak ada file sama sekali
        $fotoURL = base_url('assets/dist/images/profile-15.jpg');
    }
?>
<div class="grid grid-cols-12 gap-6">
  <!-- BEGIN: Profile Menu -->
  <div class="col-span-12 lg:col-span-4 2xl:col-span-3 flex flex-col">
    <div class="intro-y box p-5 mt-5">
      <div class="flex items-center">
        <div class="w-12 h-12 image-fit zoom-in">
          <img
            alt="Foto Siswa"
            class="rounded-full"
            src="<?= $fotoURL?>"
          />
        </div>
        <div class="ml-4">
          <div class="font-medium text-base"><?= $siswa['nama'] ?></div>
          <div class="text-slate-500 text-sm"><?= $siswa['status'] ?></div>
        </div>
      </div>

      <div class="mt-5 pt-5 border-t border-slate-200/60 dark:border-darkmode-400 space-y-3">
        <a
          href="<?= base_url('admin/siswa/detail/'.$siswa['id_siswa']) ?>"
          class="flex items-center text-slate-600 hover:text-primary"
        >
          <i data-lucide="user" class="w-4 h-4 mr-2"></i> Profil Siswa
        </a>
        <a
          href="javascript:;"
          class="flex items-center text-primary font-medium"
        >
          <i data-lucide="book" class="w-4 h-4 mr-2"></i> Nilai Raport
        </a>
      </div>

      <div class="mt-5 pt-5 border-t border-slate-200/60 dark:border-darkmode-400">
        <a href="<?= base_url('admin/siswa') ?>" class="block">
          <button type="button" class="btn btn-outline-secondary w-full">Kembali</button>
        </a>
      </div>
    </div>
    
    <!-- BEGIN: Grafik Semester -->
    <div class="intro-y box p-5 mt-5">
        <h2 class="text-lg font-medium">Grafik Perkembangan Nilai</h2>
        <div class="mt-4">
            <canvas id="semesterChart" width="400" height="200"></canvas>
        </div>
    </div>
    <!-- END: Grafik Semester -->
  </div>
  <!-- END: Profile Menu -->

  <!-- BEGIN: Konten Nilai Raport -->
  <div class="col-span-12 lg:col-span-8 2xl:col-span-9">
    <div class="intro-y box p-5 mt-5" x-data="{ tab: 1 }">
      <h2 class="text-lg font-medium">Nilai Raport Siswa</h2>

      
      <!-- TABS -->
      <div class="nav nav-tabs flex flex-wrap gap-2 mt-5" role="tablist">
        <?php foreach ($semesterData as $semId => $sem): ?>
          <button
            @click="tab = <?= $semId ?>"
            :class="{ 'bg-primary text-white': tab === <?= $semId ?>, 'bg-slate-200 text-slate-600 hover:bg-slate-300': tab !== <?= $semId ?> }"
            class="py-2 px-4 rounded-md text-sm font-medium transition-colors"
            type="button"
          >
            Semester <?= $sem['semester'] ?><br>
            <span class="text-xs"><?= $sem['tahun'] ?></span>
          </button>
        <?php endforeach; ?>
      </div>

      <!-- TAB CONTENT -->
      <?php foreach ($semesterData as $semId => $sem): ?>
        <div x-show="tab === <?= $semId ?>" class="mt-6" x-cloak>
          <?php if (empty($sem['mapel'])): ?>
            <div class="text-center text-slate-500 italic">Belum ada data nilai untuk semester ini.</div>
          <?php else: ?>
            <div class="overflow-x-auto">
              <table class="table table-report -mt-2">
                <thead>
                  <tr>
                    <th class="whitespace-nowrap text-center w-10">#</th>
                    <th class="whitespace-nowrap">Mata Pelajaran</th>
                    <th class="whitespace-nowrap min-w-[220px]">Komponen & Nilai</th>
                    <th class="whitespace-nowrap text-center w-20">Rata-rata</th>
                    <th class="whitespace-nowrap text-center w-24">Predikat</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $no = 1;
                  $jumlahmapel = 0;
                  $sumRata = 0;
                  foreach ($sem['mapel'] as $mapel):
                  // Ambil hanya komponen dengan nilai > 0
                  $nilaiList = [];
                  foreach ($mapel['komponen'] as $komp) {
                    if (isset($komp['nilai']) && $komp['nilai'] > 0) {
                    $nilaiList[] = $komp['nilai'];
                    }
                  }

                  $total = array_sum($nilaiList);
                  $rata = count($nilaiList) > 0 ? round($total / count($nilaiList), 1) : 0;

                  // Jangan tampilkan mapel yang rata-rata 0 (tidak mempengaruhi rata-rata keseluruhan)
                  if ($rata == 0) continue;

                  $predikat = $rata >= 85 ? 'A' : ($rata >= 75 ? 'B' : ($rata >= 60 ? 'C' : 'D'));
                  $badgeColor = $rata >= 85 ? 'bg-success/20 text-success' : ($rata >= 75 ? 'bg-warning/20 text-warning' : ($rata >= 60 ? 'bg-blue-200 text-blue-800' : 'bg-danger/20 text-danger'));

                  // Akumulasi untuk rata-rata keseluruhan
                  $sumRata += $rata;
                  $jumlahmapel++;
                  ?>
                  <tr class="intro-x hover:bg-slate-50 dark:hover:bg-darkmode-600/50">
                    <td class="text-center"><?= $no++ ?></td>
                    <td><div class="font-medium whitespace-nowrap"><?= ($mapel['nama']) ?></div></td>
                    <td>
                    <div class="flex flex-wrap gap-2 mt-1">
                      <?php foreach ($mapel['komponen'] as $komp): ?>
                      <?php if (isset($komp['nilai']) && $komp['nilai'] > 0): // hanya tampilkan komponen > 0 ?>
                        <span class="flex items-center bg-slate-100 dark:bg-darkmode-400/30 text-slate-700 dark:text-slate-300 text-xs px-2 py-1 rounded">
                        <span><?= ($komp['nama']) ?></span>
                        <span class="font-medium ml-1"><?= number_format($komp['nilai'], 1) ?></span>
                        </span>
                      <?php endif; ?>
                      <?php endforeach; ?>
                    </div>
                    </td>
                    <td class="text-center font-medium"><?= $rata ?></td>
                    <td class="text-center">
                    <span class="px-2 py-1 rounded-full text-xs font-medium <?= $badgeColor ?>">
                      <?= $predikat ?>
                    </span>
                    </td>
                  </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          <?php endif; ?>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
  <!-- END: Konten Nilai Raport -->
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.10/dist/cdn.min.js" defer></script>
<script>
  // Guard lucide.createIcons() in case lucide is not loaded on the page to avoid JS errors
  if (typeof lucide !== 'undefined' && lucide && typeof lucide.createIcons === 'function') {
    lucide.createIcons();
  }

  document.addEventListener('DOMContentLoaded', function () {
    const canvas = document.getElementById('semesterChart');
    if (!canvas) return; // safety: exit if canvas not present
    const ctx = canvas.getContext('2d');

    // ensure the canvas has a visible height so Chart.js can render when maintainAspectRatio = false
    canvas.style.maxHeight = canvas.style.maxHeight || '240px';

    // Data dari PHP
    const labels = <?= json_encode($chartLabels) ?>;
    const data = <?= json_encode($chartData) ?>;

    new Chart(ctx, {
      type: 'line',
      data: {
        labels: labels,
        datasets: [{
          label: 'Rata-rata Nilai Keseluruhan',
          data: data,
          borderColor: '#4f46e5', // Tailwind's indigo-600, warna primary MidOne
          backgroundColor: 'rgba(79, 70, 229, 0.1)', // Area fill
          borderWidth: 2,
          pointBackgroundColor: '#4f46e5',
          pointRadius: 4,
          pointHoverRadius: 6,
          tension: 0.3, // Kurva halus
          fill: true,
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false, // Membuat grafik mengikuti ukuran container
        plugins: {
          legend: {
            display: true,
            position: 'top',
          }
        },
        scales: {
          y: {
            beginAtZero: false, // Mulai dari nilai terendah, bukan 0
            min: 80,
            max: 100,
            title: {
              display: true,
              text: 'Nilai'
            }
          },
          x: {
            title: {
              display: true,
              text: 'Semester'
            }
          }
        }
      }
    });
  });
</script>