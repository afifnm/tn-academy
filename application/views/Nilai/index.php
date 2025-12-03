<div class="p-4">
    <?php if($this->session->flashdata('error')): ?>
        <div class="alert alert-danger mb-4"><?= $this->session->flashdata('error') ?></div>
    <?php endif; ?>
    <?php if($this->session->userdata('role')=='admin'): ?>
    <form method="GET" class="intro-y col-span-12 flex flex-wrap xl:flex-nowrap items-center mt-2 mb-5">
        <div class="flex w-full sm:w-auto">
            <div class="w-52 relative text-slate-500">
                <select name="id_kelas" class="form-select box w-52" required>
                    <option value="">-- Pilih Kelas --</option>
                    <?php foreach($kelas as $k): ?>
                        <option value="<?= $k['id_kelas'] ?>" <?= isset($id_kelas) && $id_kelas==$k['id_kelas'] ? 'selected':'' ?>>
                            <?= htmlspecialchars($k['nama_kelas']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="w-52 relative text-slate-500 ml-2">
                <select name="id_ta" class="form-select box w-52" required>
                    <option value="">-- Pilih Tahun Ajaran --</option>
                    <?php foreach($tahun_ajaran as $ta): ?>
                        <option value="<?= $ta->id_ta ?>" <?= isset($id_ta) && $id_ta==$ta->id_ta ? 'selected':'' ?>>
                            <?= htmlspecialchars($ta->tahun . ' - ' . $ta->semester) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary shadow-md ml-2">Tampilkan Mapel</button>
        </div>
    </form>
    <?php endif; ?>
    <?php if($this->session->userdata('role')=='guru'): ?>
    <form method="GET" class="intro-y col-span-12 flex flex-wrap xl:flex-nowrap items-center mt-2 mb-5" action="<?= base_url('nilai/guru') ?>">
        <div class="flex w-full sm:w-auto">
            <div class="w-52 relative text-slate-500">
                <select name="id_kelas" class="form-select box w-52" required>
                    <option value="">-- Pilih Kelas --</option>
                    <?php foreach($kelas as $k): ?>
                        <option value="<?= $k['id_kelas'] ?>" <?= isset($id_kelas) && $id_kelas==$k['id_kelas'] ? 'selected':'' ?>>
                            <?= htmlspecialchars($k['nama_kelas']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="w-52 relative text-slate-500 ml-2">
                <select name="id_ta" class="form-select box w-52" required>
                    <option value="">-- Pilih Tahun Ajaran --</option>
                    <?php foreach($tahun_ajaran as $ta): ?>
                        <option value="<?= $ta->id_ta ?>" <?= isset($id_ta) && $id_ta==$ta->id_ta ? 'selected':'' ?>>
                            <?= htmlspecialchars($ta->tahun . ' - ' . $ta->semester) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary shadow-md ml-2">Tampilkan Nilai</button>
        </div>
    </form>
    <?php endif; ?>
    <?php if($this->session->userdata('role')=='admin'): ?>
    <?php if (isset($id_kelas) && isset($id_ta)): ?>
        <form method="GET" class="intro-y col-span-12 flex flex-wrap xl:flex-nowrap items-center mt-2 mb-5">
            <input type="hidden" name="id_kelas" value="<?= $id_kelas ?>">
            <input type="hidden" name="id_ta" value="<?= $id_ta ?>">
            <div class="flex w-full sm:w-auto">
                <div class="w-52 relative text-slate-500">
                    <select name="id_mapel" class="form-select box w-52" required>
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
                <button type="submit" class="btn btn-primary shadow-md ml-2">Tampilkan Input Nilai</button>
            </div>
        </form>
    <?php endif; ?>
    <?php endif; ?>

    <?php if (isset($id_kelas) && isset($id_ta) && isset($id_mapel)): ?>
        <div class="intro-y box p-5 w-full overflow-auto bg-white rounded-lg shadow-sm">
            <h3 class="font-medium text-lg mb-4">Input Nilai: <?= htmlspecialchars($mapel_terpilih->nama_mapel ?? '—') ?></h3>

            <?php if(!empty($siswa) && !empty($mapel_terpilih)): ?>
                <?php if (!empty($mapel_terpilih->komponen)): ?>
                    <form action="<?= base_url('nilai/save') ?>" method="POST">
                        <input type="hidden" name="id_kelas" value="<?= $id_kelas ?>">
                        <input type="hidden" name="id_ta" value="<?= $id_ta ?>">
                        <input type="hidden" name="id_mapel" value="<?= $id_mapel ?>">

                        <div class="overflow-x-auto">
                            <table class="table table-striped w-full text-sm table-fixed">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="px-3 py-2 w-12 text-center">No</th>
                                        <th class="px-3 py-2 w-64">Siswa</th>
                                        <?php foreach($mapel_terpilih->komponen as $komponen): ?>
                                            <th class="px-3 py-2 w-32 text-center"><?= htmlspecialchars($komponen['nama_komponen']) ?></th>
                                        <?php endforeach; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no=1; foreach($siswa as $s): ?>
                                        <tr class="border-b">
                                            <td class="px-3 py-2 text-center"><?= $no++ ?></td>
                                            <td class="px-3 py-2 font-medium"><?= htmlspecialchars($s->nama) ?></td>
                                            <?php foreach($mapel_terpilih->komponen as $komponen): ?>
                                                <td class="px-3 py-2 text-center">
                                                    <input type="number" step="0.01" min="0" max="100"
                                                        name="nilai[<?= $s->id_enroll ?>][<?= $mapel_terpilih->id_kelas_mapel ?>][<?= $komponen['id_komponen'] ?>]"
                                                        value="<?= $this->Nilai_model->get_nilai_satu($s->id_enroll, $mapel_terpilih->id_mapel, $komponen['id_komponen']) ?>"
                                                        class="form-input w-20 text-center text-sm border rounded">
                                                </td>
                                            <?php endforeach; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <button type="submit" class="btn btn-primary w-25 rounded-lg mt-4">
                            Simpan Nilai
                        </button>
                        <a href="<?= base_url('nilai/daftar/'.$id_kelas.'/'.$id_ta.'/'.$id_mapel) ?>" class="btn btn-info ml-2 mt-4">
                            Lihat Daftar Nilai
                        </a>
                    </form>
                <?php else: ?>
                    <p class="text-red-500">Tidak ada komponen nilai untuk mapel ini. Silakan atur di menu Enroll Mapel.</p>
                <?php endif; ?>
            <?php else: ?>
                <p class="text-gray-600 text-sm">Data tidak tersedia.</p>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="intro-y box p-5 w-full bg-white rounded-lg shadow-sm">
            <p class="text-gray-600 text-sm">Pilih Kelas, Tahun Ajaran, dan Mapel terlebih dahulu.</p>
        </div>
    <?php endif; ?>
</div>

<script>
$(document).ready(function(){
    if ($('#nilai_terisi').length) {
        $('#nilai_terisi').DataTable({ "pageLength": 50 });
    }
});
</script>