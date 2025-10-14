<div class="grid grid-cols-12 gap-6">
    <!-- BEGIN: Profile Menu -->
    <div class="col-span-12 lg:col-span-4 2xl:col-span-3 flex lg:block flex-col-reverse">
        <div class="intro-y box mt-5">
            <div class="relative flex items-center p-5">
                <div class="w-12 h-12 image-fit">
                    <img alt="Foto Siswa" class="rounded-full" 
                         src="<?= !empty($siswa['foto']) ? base_url('assets/upload/foto_siswa/'.$siswa['foto']) : base_url('assets/dist/images/profile-15.jpg') ?>">
                </div>
                <div class="ml-4 mr-auto">
                    <div class="font-medium text-base"><?= $siswa['nama'] ?></div>
                    <div class="text-slate-500"><?= $siswa['status'] ?></div>
                </div>
            </div>

            <div class="p-5 border-t border-slate-200/60 dark:border-darkmode-400">
                <a href="<?= base_url('admin/siswa/detail/'.$siswa['id_siswa']) ?>" class="flex items-center font-medium text-slate-600 hover:text-primary">
                    <i data-lucide="user" class="w-4 h-4 mr-2"></i> Profil Siswa
                </a>
                <a class="text-primary flex items-center font-medium mt-5" href="javascript:;">
                    <i data-lucide="book" class="w-4 h-4 mr-2"></i> Nilai Raport
                </a>
            </div>
            <div class="p-5 border-t border-slate-200/60 dark:border-darkmode-400">
                <a href="<?=base_url('admin/siswa')?>" class="py-1 px-1">
                    <button type="button" class="btn btn-outline-secondary w-full">Kembali</button>
                </a>
            </div>
        </div>
    </div>
    <!-- END: Profile Menu -->

<!-- BEGIN: Konten Nilai Raport -->
<div class="col-span-12 lg:col-span-8 2xl:col-span-9">
  <div class="intro-y box mt-5" x-data="{ tab: 1 }">
    <div class="flex items-center p-5 border-b border-slate-200/60">
      <h2 class="font-medium text-base mr-auto">Nilai Raport Siswa</h2>
    </div>

    <?php
    // Data Semester
    $semesterData = [
      ['id' => 1, 'semester' => 1, 'tahun' => '2022/2023'],
      ['id' => 2, 'semester' => 2, 'tahun' => '2022/2023'],
      ['id' => 3, 'semester' => 3, 'tahun' => '2023/2024'],
      ['id' => 4, 'semester' => 4, 'tahun' => '2023/2024'],
      ['id' => 5, 'semester' => 5, 'tahun' => '2024/2025'],
    ];

    // Data Dummy Banyak
    $mapelData = [
      [
        'nama' => 'Matematika',
        'komponen' => [
          ['nama' => 'Tugas', 'nilai' => 85],
          ['nama' => 'UTS', 'nilai' => 88],
          ['nama' => 'UAS', 'nilai' => 90],
        ]
      ],
      [
        'nama' => 'Bahasa Indonesia',
        'komponen' => [
          ['nama' => 'Tugas', 'nilai' => 82],
          ['nama' => 'UTS', 'nilai' => 80],
          ['nama' => 'UAS', 'nilai' => 84],
        ]
      ],
      [
        'nama' => 'Bahasa Inggris',
        'komponen' => [
          ['nama' => 'Tugas', 'nilai' => 87],
          ['nama' => 'UTS', 'nilai' => 85],
          ['nama' => 'UAS', 'nilai' => 89],
        ]
      ],
      [
        'nama' => 'Informatika',
        'komponen' => [
          ['nama' => 'Proyek', 'nilai' => 92],
          ['nama' => 'UTS', 'nilai' => 95],
          ['nama' => 'UAS', 'nilai' => 93],
        ]
      ],
      [
        'nama' => 'Fisika',
        'komponen' => [
          ['nama' => 'Tugas', 'nilai' => 83],
          ['nama' => 'UTS', 'nilai' => 81],
          ['nama' => 'UAS', 'nilai' => 86],
        ]
      ],
      [
        'nama' => 'Kimia',
        'komponen' => [
          ['nama' => 'Tugas', 'nilai' => 79],
          ['nama' => 'UTS', 'nilai' => 82],
          ['nama' => 'UAS', 'nilai' => 80],
        ]
      ],
      [
        'nama' => 'Biologi',
        'komponen' => [
          ['nama' => 'Tugas', 'nilai' => 88],
          ['nama' => 'UTS', 'nilai' => 85],
          ['nama' => 'UAS', 'nilai' => 89],
        ]
      ],
      [
        'nama' => 'Pendidikan Pancasila',
        'komponen' => [
          ['nama' => 'Tugas', 'nilai' => 91],
          ['nama' => 'UTS', 'nilai' => 92],
          ['nama' => 'UAS', 'nilai' => 90],
        ]
      ],
    ];
    ?>

    <!-- TAB NAVIGATION -->
    <div class="border-b border-gray-200">
      <nav class="flex flex-wrap -mb-px text-sm font-medium text-center">
        <?php foreach ($semesterData as $sem) : ?>
          <button
            class="px-4 py-3 border-b-2"
            :class="tab === <?= $sem['id'] ?> ? 'border-primary text-primary font-semibold' : 'border-transparent text-gray-500 hover:text-primary'"
            @click="tab = <?= $sem['id'] ?>">
            Semester <?= $sem['semester'] ?> <br><span class="text-xs text-gray-400"><?= $sem['tahun'] ?></span>
          </button>
        <?php endforeach; ?>
      </nav>
    </div>

    <!-- TAB CONTENT -->
    <?php foreach ($semesterData as $sem) : ?>
      <div x-show="tab === <?= $sem['id'] ?>" class="p-5 transition">
        <div class="overflow-x-auto">
          <table class="w-full text-sm text-left border border-slate-200">
            <thead class="bg-slate-100 text-slate-700">
              <tr>
                <th class="px-3 py-2 border text-center">No</th>
                <th class="px-3 py-2 border">Mata Pelajaran</th>
                <th class="px-3 py-2 border">Komponen & Nilai</th>
                <th class="px-3 py-2 border text-center">Rata-rata</th>
                <th class="px-3 py-2 border text-center">Predikat</th>
              </tr>
            </thead>
            <tbody>
              <?php
              $no = 1;
              foreach ($mapelData as $mapel) :
                $total = array_sum(array_column($mapel['komponen'], 'nilai'));
                $rata = round($total / count($mapel['komponen']), 1);

                if ($rata >= 85) {
                  $predikat = 'A';
                  $warna = 'text-green-600';
                } elseif ($rata >= 75) {
                  $predikat = 'B';
                  $warna = 'text-yellow-600';
                } else {
                  $predikat = 'C';
                  $warna = 'text-red-500';
                }
              ?>
                <tr class="hover:bg-slate-50">
                  <td class="px-3 py-2 border text-center"><?= $no++ ?></td>
                  <td class="px-3 py-2 border font-medium"><?= $mapel['nama'] ?></td>
                  <td class="px-3 py-2 border">
                    <?php foreach ($mapel['komponen'] as $komp) : ?>
                      <div class="flex justify-between">
                        <span><?= $komp['nama'] ?></span>
                        <span class="font-semibold text-slate-600"><?= $komp['nilai'] ?></span>
                      </div>
                    <?php endforeach; ?>
                  </td>
                  <td class="px-3 py-2 border text-center font-semibold text-slate-700">
                    <?= $rata ?>
                  </td>
                  <td class="px-3 py-2 border text-center font-bold <?= $warna ?>">
                    <?= $predikat ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>

<!-- Alpine.js untuk Tab -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<!-- END: Konten Nilai Raport -->

</div>

<script>
    lucide.createIcons();
</script>
