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
                  foreach ($sem['mapel'] as $mapel):
                    $nilaiList = array_column($mapel['komponen'], 'nilai');
                    $total = array_sum($nilaiList);
                    $rata = count($nilaiList) > 0 ? round($total / count($nilaiList), 1) : 0;
                    $predikat = $rata >= 85 ? 'A' : ($rata >= 75 ? 'B' : ($rata >= 60 ? 'C' : 'D'));
                    $badgeColor = $rata >= 85 ? 'bg-success/20 text-success' : ($rata >= 75 ? 'bg-warning/20 text-warning' : ($rata >= 60 ? 'bg-blue-200 text-blue-800' : 'bg-danger/20 text-danger'));
                  ?>
                    <tr class="intro-x hover:bg-slate-50 dark:hover:bg-darkmode-600/50">
                      <td class="text-center"><?= $no++ ?></td>
                      <td><div class="font-medium whitespace-nowrap"><?= esc($mapel['nama']) ?></div></td>
                      <td>
                        <div class="flex flex-wrap gap-2 mt-1">
                          <?php foreach ($mapel['komponen'] as $komp): ?>
                            <span class="flex items-center bg-slate-100 dark:bg-darkmode-400/30 text-slate-700 dark:text-slate-300 text-xs px-2 py-1 rounded">
                              <span><?= esc($komp['nama']) ?></span>
                              <span class="font-medium ml-1"><?= number_format($komp['nilai'], 1) ?></span>
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

<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.10/dist/cdn.min.js" defer></script>
<script>
  lucide.createIcons();
</script>