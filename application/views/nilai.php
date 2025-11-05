<div class="p-4">
    <h2 class="font-medium text-base mb-4">Kelola Nilai</h2>

    <?php if($this->session->flashdata('error')): ?>
        <div class="alert alert-danger mb-4"><?= $this->session->flashdata('error') ?></div>
    <?php endif; ?>

    <!-- DUO KOLOM: KIRI & KANAN -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="intro-y box p-5 w-full overflow-auto lg:col-span-1 bg-white rounded-lg shadow-sm">
            <h3 class="font-medium text-lg mb-4">Filter & Pilih</h3>

            <div class="mb-6">
                <h4 class="font-medium text-md mb-3 flex items-center text-blue-800">
                    <span class="bg-blue-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs mr-2">1</span>
                    Kelas & Tahun Ajaran
                </h4>
                <form method="GET" class="max-w-xs">
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Kelas</label>
                        <select name="id_kelas" class="form-select w-full rounded-lg border-gray-300" required>
                            <option value="">-- Pilih Kelas --</option>
                            <?php foreach($kelas as $k): ?>
                                <option value="<?= $k['id_kelas'] ?>" <?= isset($id_kelas) && $id_kelas==$k['id_kelas'] ? 'selected':'' ?>>
                                    <?= htmlspecialchars($k['nama_kelas']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Tahun Ajaran</label>
                        <select name="id_ta" class="form-select w-full rounded-lg border-gray-300" required>
                            <option value="">-- Pilih Tahun Ajaran --</option>
                            <?php foreach($tahun_ajaran as $ta): ?>
                                <option value="<?= $ta->id_ta ?>" <?= isset($id_ta) && $id_ta==$ta->id_ta ? 'selected':'' ?>>
                                    <?= htmlspecialchars($ta->tahun . ' - ' . $ta->semester) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-full rounded-lg">
                        Tampilkan Mapel
                    </button>
                </form>
            </div>

            <?php if (isset($id_kelas) && isset($id_ta)): ?>
                <div class="mb-6 border-t pt-6">
                    <h4 class="font-medium text-md mb-3 flex items-center text-green-800">
                        <span class="bg-green-500 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs mr-2">2</span>
                        Mata Pelajaran
                    </h4>
                    <form method="GET" class="max-w-xs">
                        <input type="hidden" name="id_kelas" value="<?= $id_kelas ?>">
                        <input type="hidden" name="id_ta" value="<?= $id_ta ?>">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Pilih Mapel</label>
                            <select name="id_mapel" class="form-select w-full rounded-lg border-gray-300" required>
                                <option value="">-- Pilih Mapel --</option>
                                <?php if (!empty($mapel_list)): ?>
                                    <?php foreach($mapel_list as $m): ?>
                                        <option value="<?= $m['id_mapel'] ?>" <?= isset($id_mapel) && $id_mapel==$m['id_mapel'] ? 'selected':'' ?>>
                                            <?= htmlspecialchars($m['nama_mapel']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <option disabled>Tidak ada mapel tersedia</option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-full rounded-lg">
                            Tampilkan Input Nilai
                        </button>
                    </form>
                </div>
            <?php endif; ?>
        </div>

        <!-- KOLOM KANAN: Input Nilai -->
        <div class="intro-y box p-5 w-full overflow-auto lg:col-span-1 bg-white rounded-lg shadow-sm">
            <h3 class="font-medium text-lg mb-4">Input Nilai</h3>

            <?php if (isset($id_kelas) && isset($id_ta) && isset($id_mapel)): ?>
                <?php if(!empty($siswa) && !empty($mapel_terpilih)): ?>
                    <form action="<?= base_url('nilai/save') ?>" method="POST">
                        <input type="hidden" name="id_kelas" value="<?= $id_kelas ?>">
                        <input type="hidden" name="id_ta" value="<?= $id_ta ?>">
                        <input type="hidden" name="id_mapel" value="<?= $id_mapel ?>">

                        <div class="overflow-x-auto">
                            <table class="table table-striped w-full mb-4 text-sm">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="px-2 py-1">No</th>
                                        <th class="px-2 py-1">Siswa</th>
                                        <?php foreach($mapel_terpilih->komponen as $komponen): ?>
                                            <th class="px-2 py-1"><?= htmlspecialchars($komponen['nama_komponen']) ?></th>
                                        <?php endforeach; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no=1; foreach($siswa as $s): ?>
                                        <tr class="border-b">
                                            <td class="px-2 py-1"><?= $no++ ?></td>
                                            <td class="px-2 py-1 font-medium"><?= htmlspecialchars($s->nama) ?></td>
                                            <?php foreach($mapel_terpilih->komponen as $komponen): ?>
                                                <td class="px-2 py-1">
                                                    <input type="number" step="0.01" min="0" max="100"
                                                        name="nilai[<?= $s->id_enroll ?>][<?= $mapel_terpilih->id_kelas_mapel ?>][<?= $komponen['id_komponen'] ?>]"
                                                        value="<?= $this->Nilai_model->get_nilai_satu($s->id_enroll, $mapel_terpilih->id_mapel, $komponen['id_komponen']) ?>"
                                                        class="form-input w-16 text-center text-sm border rounded">
                                                </td>
                                            <?php endforeach; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <button type="submit" class="btn btn-primary w-full rounded-lg">
                            Simpan Nilai
                        </button>
                    </form>
                <?php else: ?>
                    <p class="text-gray-600 text-sm">Data tidak tersedia.</p>
                <?php endif; ?>
            <?php else: ?>
                <p class="text-gray-600 text-sm">Pilih Kelas, Tahun Ajaran, dan Mapel terlebih dahulu.</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    if ($('#nilai_terisi').length) {
        $('#nilai_terisi').DataTable({ "pageLength": 50 });
    }
});
</script>