<div class="grid grid-cols-12 gap-6">
  <!-- BEGIN: Profile Menu -->
  <div class="col-span-12 lg:col-span-4 2xl:col-span-3 flex flex-col">
    <div class="intro-y box p-5 mt-5">
      <div class="flex items-center">
        <div class="w-12 h-12 image-fit zoom-in">
          <img
            alt="Foto Siswa"
            class="rounded-full"
            src="<?= !empty($siswa['foto']) ? base_url('assets/upload/foto_siswa/'.$siswa['foto']) : base_url('assets/dist/images/profile-15.jpg') ?>"
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

      <?php
      $semesterData = [
        ['id' => 1, 'semester' => 1, 'tahun' => '2022/2023'],
        ['id' => 2, 'semester' => 2, 'tahun' => '2022/2023'],
        ['id' => 3, 'semester' => 3, 'tahun' => '2023/2024'],
        ['id' => 4, 'semester' => 4, 'tahun' => '2023/2024'],
        ['id' => 5, 'semester' => 5, 'tahun' => '2024/2025'],
      ];

      // Data nilai per semester - disimulasikan dengan variasi
      $dataPerSemester = [
          1 => [ // Semester 1
            ['nama' => 'Matematika', 'komponen' => [['nama' => 'Tugas', 'nilai' => 85], ['nama' => 'UTS', 'nilai' => 88], ['nama' => 'UAS', 'nilai' => 90]]],
            ['nama' => 'Bahasa Indonesia', 'komponen' => [['nama' => 'Tugas', 'nilai' => 82], ['nama' => 'UTS', 'nilai' => 80], ['nama' => 'UAS', 'nilai' => 84]]],
            ['nama' => 'Bahasa Inggris', 'komponen' => [['nama' => 'Tugas', 'nilai' => 87], ['nama' => 'UTS', 'nilai' => 85], ['nama' => 'UAS', 'nilai' => 89]]],
            ['nama' => 'Informatika', 'komponen' => [['nama' => 'Proyek', 'nilai' => 92], ['nama' => 'UTS', 'nilai' => 95], ['nama' => 'UAS', 'nilai' => 93]]],
            ['nama' => 'Fisika', 'komponen' => [['nama' => 'Tugas', 'nilai' => 83], ['nama' => 'UTS', 'nilai' => 81], ['nama' => 'UAS', 'nilai' => 86]]],
            ['nama' => 'Kimia', 'komponen' => [['nama' => 'Tugas', 'nilai' => 79], ['nama' => 'UTS', 'nilai' => 82], ['nama' => 'UAS', 'nilai' => 80]]],
            ['nama' => 'Biologi', 'komponen' => [['nama' => 'Tugas', 'nilai' => 88], ['nama' => 'UTS', 'nilai' => 85], ['nama' => 'UAS', 'nilai' => 89]]],
            ['nama' => 'Pendidikan Pancasila', 'komponen' => [['nama' => 'Tugas', 'nilai' => 91], ['nama' => 'UTS', 'nilai' => 92], ['nama' => 'UAS', 'nilai' => 90]]],
          ],
          2 => [ // Semester 2
            ['nama' => 'Matematika', 'komponen' => [['nama' => 'Tugas', 'nilai' => 86], ['nama' => 'UTS', 'nilai' => 89], ['nama' => 'UAS', 'nilai' => 91]]],
            ['nama' => 'Bahasa Indonesia', 'komponen' => [['nama' => 'Tugas', 'nilai' => 83], ['nama' => 'UTS', 'nilai' => 81], ['nama' => 'UAS', 'nilai' => 85]]],
            ['nama' => 'Bahasa Inggris', 'komponen' => [['nama' => 'Tugas', 'nilai' => 88], ['nama' => 'UTS', 'nilai' => 86], ['nama' => 'UAS', 'nilai' => 90]]],
            ['nama' => 'Informatika', 'komponen' => [['nama' => 'Proyek', 'nilai' => 93], ['nama' => 'UTS', 'nilai' => 96], ['nama' => 'UAS', 'nilai' => 94]]],
            ['nama' => 'Fisika', 'komponen' => [['nama' => 'Tugas', 'nilai' => 84], ['nama' => 'UTS', 'nilai' => 82], ['nama' => 'UAS', 'nilai' => 87]]],
            ['nama' => 'Kimia', 'komponen' => [['nama' => 'Tugas', 'nilai' => 80], ['nama' => 'UTS', 'nilai' => 83], ['nama' => 'UAS', 'nilai' => 81]]],
            ['nama' => 'Biologi', 'komponen' => [['nama' => 'Tugas', 'nilai' => 89], ['nama' => 'UTS', 'nilai' => 86], ['nama' => 'UAS', 'nilai' => 90]]],
            ['nama' => 'Pendidikan Pancasila', 'komponen' => [['nama' => 'Tugas', 'nilai' => 92], ['nama' => 'UTS', 'nilai' => 93], ['nama' => 'UAS', 'nilai' => 91]]],
          ],
          3 => [ // Semester 3
            ['nama' => 'Matematika', 'komponen' => [['nama' => 'Tugas', 'nilai' => 87], ['nama' => 'UTS', 'nilai' => 90], ['nama' => 'UAS', 'nilai' => 92]]],
            ['nama' => 'Bahasa Indonesia', 'komponen' => [['nama' => 'Tugas', 'nilai' => 84], ['nama' => 'UTS', 'nilai' => 82], ['nama' => 'UAS', 'nilai' => 86]]],
            ['nama' => 'Bahasa Inggris', 'komponen' => [['nama' => 'Tugas', 'nilai' => 89], ['nama' => 'UTS', 'nilai' => 87], ['nama' => 'UAS', 'nilai' => 91]]],
            ['nama' => 'Informatika', 'komponen' => [['nama' => 'Proyek', 'nilai' => 94], ['nama' => 'UTS', 'nilai' => 97], ['nama' => 'UAS', 'nilai' => 95]]],
            ['nama' => 'Fisika', 'komponen' => [['nama' => 'Tugas', 'nilai' => 85], ['nama' => 'UTS', 'nilai' => 83], ['nama' => 'UAS', 'nilai' => 88]]],
            ['nama' => 'Kimia', 'komponen' => [['nama' => 'Tugas', 'nilai' => 81], ['nama' => 'UTS', 'nilai' => 84], ['nama' => 'UAS', 'nilai' => 82]]],
            ['nama' => 'Biologi', 'komponen' => [['nama' => 'Tugas', 'nilai' => 90], ['nama' => 'UTS', 'nilai' => 87], ['nama' => 'UAS', 'nilai' => 91]]],
            ['nama' => 'Pendidikan Pancasila', 'komponen' => [['nama' => 'Tugas', 'nilai' => 93], ['nama' => 'UTS', 'nilai' => 94], ['nama' => 'UAS', 'nilai' => 92]]],
          ],
          4 => [ // Semester 4
            ['nama' => 'Matematika', 'komponen' => [['nama' => 'Tugas', 'nilai' => 88], ['nama' => 'UTS', 'nilai' => 91], ['nama' => 'UAS', 'nilai' => 93]]],
            ['nama' => 'Bahasa Indonesia', 'komponen' => [['nama' => 'Tugas', 'nilai' => 85], ['nama' => 'UTS', 'nilai' => 83], ['nama' => 'UAS', 'nilai' => 87]]],
            ['nama' => 'Bahasa Inggris', 'komponen' => [['nama' => 'Tugas', 'nilai' => 90], ['nama' => 'UTS', 'nilai' => 88], ['nama' => 'UAS', 'nilai' => 92]]],
            ['nama' => 'Informatika', 'komponen' => [['nama' => 'Proyek', 'nilai' => 95], ['nama' => 'UTS', 'nilai' => 98], ['nama' => 'UAS', 'nilai' => 96]]],
            ['nama' => 'Fisika', 'komponen' => [['nama' => 'Tugas', 'nilai' => 86], ['nama' => 'UTS', 'nilai' => 84], ['nama' => 'UAS', 'nilai' => 89]]],
            ['nama' => 'Kimia', 'komponen' => [['nama' => 'Tugas', 'nilai' => 82], ['nama' => 'UTS', 'nilai' => 85], ['nama' => 'UAS', 'nilai' => 83]]],
            ['nama' => 'Biologi', 'komponen' => [['nama' => 'Tugas', 'nilai' => 91], ['nama' => 'UTS', 'nilai' => 88], ['nama' => 'UAS', 'nilai' => 92]]],
            ['nama' => 'Pendidikan Pancasila', 'komponen' => [['nama' => 'Tugas', 'nilai' => 94], ['nama' => 'UTS', 'nilai' => 95], ['nama' => 'UAS', 'nilai' => 93]]],
          ],
          5 => [ // Semester 5
            ['nama' => 'Matematika', 'komponen' => [['nama' => 'Tugas', 'nilai' => 89], ['nama' => 'UTS', 'nilai' => 92], ['nama' => 'UAS', 'nilai' => 94]]],
            ['nama' => 'Bahasa Indonesia', 'komponen' => [['nama' => 'Tugas', 'nilai' => 86], ['nama' => 'UTS', 'nilai' => 84], ['nama' => 'UAS', 'nilai' => 88]]],
            ['nama' => 'Bahasa Inggris', 'komponen' => [['nama' => 'Tugas', 'nilai' => 91], ['nama' => 'UTS', 'nilai' => 89], ['nama' => 'UAS', 'nilai' => 93]]],
            ['nama' => 'Informatika', 'komponen' => [['nama' => 'Proyek', 'nilai' => 96], ['nama' => 'UTS', 'nilai' => 99], ['nama' => 'UAS', 'nilai' => 97]]],
            ['nama' => 'Fisika', 'komponen' => [['nama' => 'Tugas', 'nilai' => 87], ['nama' => 'UTS', 'nilai' => 85], ['nama' => 'UAS', 'nilai' => 90]]],
            ['nama' => 'Kimia', 'komponen' => [['nama' => 'Tugas', 'nilai' => 83], ['nama' => 'UTS', 'nilai' => 86], ['nama' => 'UAS', 'nilai' => 84]]],
            ['nama' => 'Biologi', 'komponen' => [['nama' => 'Tugas', 'nilai' => 92], ['nama' => 'UTS', 'nilai' => 89], ['nama' => 'UAS', 'nilai' => 93]]],
            ['nama' => 'Pendidikan Pancasila', 'komponen' => [['nama' => 'Tugas', 'nilai' => 95], ['nama' => 'UTS', 'nilai' => 96], ['nama' => 'UAS', 'nilai' => 94]]],
          ],
      ];

      // Kumpulkan data untuk grafik
      $chartLabels = [];
      $chartData = [];

      foreach ($semesterData as $sem) {
          $nilaiSemester = $dataPerSemester[$sem['id']] ?? []; // Ambil data semester

          if (!empty($nilaiSemester)) {
              $totalRata = array_sum(array_map(function($m) {
                  return round(array_sum(array_column($m['komponen'], 'nilai')) / count($m['komponen']), 1);
              }, $nilaiSemester));
              $rataKeseluruhan = round($totalRata / count($nilaiSemester), 1);
          } else {
              $rataKeseluruhan = 0; // Default jika tidak ada data
          }

          $chartLabels[] = $sem['semester'];
          $chartData[] = $rataKeseluruhan;
      }
      ?>

      <!-- TABS -->
      <div class="nav nav-tabs flex flex-wrap gap-2 mt-5" role="tablist">
        <?php foreach ($semesterData as $sem): ?>
          <button
            @click="tab = <?= $sem['id'] ?>"
            :class="{ 'bg-primary text-white': tab === <?= $sem['id'] ?>, 'bg-slate-200 text-slate-600 hover:bg-slate-300': tab !== <?= $sem['id'] ?> }"
            class="py-2 px-4 rounded-md text-sm font-medium transition-colors"
            type="button"
          >
            Semester <?= $sem['semester'] ?><br>
            <span class="text-xs"><?= $sem['tahun'] ?></span>
          </button>
        <?php endforeach; ?>
      </div>

      <!-- TAB CONTENT -->
      <?php foreach ($semesterData as $sem):
          $mapelData = $dataPerSemester[$sem['id']] ?? []; // Ambil data mata pelajaran untuk semester ini
      ?>
        <div x-show="tab === <?= $sem['id'] ?>" class="mt-6" x-cloak>
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
                foreach ($mapelData as $mapel):
                  $total = array_sum(array_column($mapel['komponen'], 'nilai'));
                  $rata = round($total / count($mapel['komponen']), 1);
                  $predikat = $rata >= 85 ? 'A' : ($rata >= 75 ? 'B' : 'C');
                  $badgeColor = $rata >= 85 ? 'bg-success/20 text-success' : ($rata >= 75 ? 'bg-warning/20 text-warning' : 'bg-danger/20 text-danger');
                ?>
                  <tr class="intro-x hover:bg-slate-50 dark:hover:bg-darkmode-600/50">
                    <td class="text-center"><?= $no++ ?></td>
                    <td>
                      <div class="font-medium whitespace-nowrap"><?= $mapel['nama'] ?></div>
                    </td>
                    <td>
                      <div class="flex flex-wrap gap-2 mt-1">
                        <?php foreach ($mapel['komponen'] as $komp): ?>
                          <span class="flex items-center bg-slate-100 dark:bg-darkmode-400/30 text-slate-700 dark:text-slate-300 text-xs px-2 py-1 rounded">
                            <span><?= $komp['nama'] ?></span>
                            <span class="font-medium ml-1"><?= $komp['nilai'] ?></span>
                          </span>
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
                  <tr class="intro-x bg-primary/10 dark:bg-darkmode-400/20">
                    <td colspan="3" class="text-center font-medium">Rata-rata Nilai Keseluruhan</td>
                    <?php
                    if (!empty($mapelData)) {
                        $totalRata = array_sum(array_map(function($m) {
                          return round(array_sum(array_column($m['komponen'], 'nilai')) / count($m['komponen']), 1);
                        }, $mapelData));
                        $rataKeseluruhan = round($totalRata / count($mapelData), 1);
                        $predikatKeseluruhan = $rataKeseluruhan >= 85 ? 'A' : ($rataKeseluruhan >= 75 ? 'B' : 'C');
                        $badgeColorKeseluruhan = $rataKeseluruhan >= 85 ? 'bg-success/20 text-success' : ($rataKeseluruhan >= 75 ? 'bg-warning/20 text-warning' : 'bg-danger/20 text-danger');
                    } else {
                        $rataKeseluruhan = 0;
                        $predikatKeseluruhan = '-';
                        $badgeColorKeseluruhan = 'bg-slate-200 text-slate-500';
                    }
                    ?>
                    <td class="text-center font-medium"><?= $rataKeseluruhan ?></td>
                    <td class="text-center">
                      <span class="px-2 py-1 rounded-full text-xs font-medium <?= $badgeColorKeseluruhan ?>">
                        <?= $predikatKeseluruhan ?>
                      </span>
                    </td>
                  </tr>
              </tbody>
            </table>
          </div>
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