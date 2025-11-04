<div class="p-4">

    <?php if (!isset($id_kelas) || !isset($id_ta)): ?>
        <div class="bg-white p-5 rounded border mb-6 max-w-2xl">
            <h3 class="font-medium mb-4">Langkah 1: Pilih Kelas dan Tahun Ajaran</h3>
            <form method="GET">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Kelas</label>
                        <select name="id_kelas" class="form-select w-full"   required>
                        <option value="">-- Pilih Kelas --</option>
                            <?php foreach($kelas as $k): ?>
                                <option value="<?= $k['id_kelas'] ?>"><?= htmlspecialchars($k['nama_kelas']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Tahun Ajaran</label>
                        <select name="id_ta" class="form-select w-full" required>
                            <option value="">-- Pilih Tahun Ajaran --</option>
                            <?php foreach($tahun_ajaran as $ta): ?>
                                <option value="<?= $ta->id_ta ?>"><?= htmlspecialchars($ta->tahun . ' - ' . $ta->semester) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary mt-4 w-full md:w-auto">Tampilkan Daftar Mapel</button>
            </form>
        </div>
    <?php endif; ?>

    <?php if (isset($id_kelas) && isset($id_ta) && !isset($id_mapel)): ?>
        <div class="bg-white p-5 rounded border mb-6 max-w-2xl">
            <h3 class="font-medium mb-4">
                Langkah 2: Pilih Mata Pelajaran  
                <span class="text-sm font-normal text-gray-600">
                    (Kelas: <?= $this->Kelas_model->get_nama($id_kelas) ?> | TA: <?= $this->db->get_where('tahun_ajaran', ['id_ta' => $id_ta])->row()->tahun ?? '—' ?>)
                </span>
            </h3>
            <form method="GET">
                <input type="hidden" name="id_kelas" value="<?= $id_kelas ?>">
                <input type="hidden" name="id_ta" value="<?= $id_ta ?>">
                <div class="mb-4">
                    <label class="block text-sm font-medium mb-1">Mata Pelajaran</label>
                    <select name="id_mapel" class="form-select w-full md:w-64" required>
                        <option value="">-- Pilih Mapel --</option>
                        <?php if (!empty($mapel_list)): ?>
                            <?php foreach($mapel_list as $m): ?>
                                <option value="<?= $m['id_mapel'] ?>"><?= htmlspecialchars($m['nama_mapel']) ?></option>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <option disabled>Tidak ada mapel tersedia</option>
                        <?php endif; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary w-full md:w-auto">Tampilkan Form Input Nilai</button>
            </form>
        </div>
    <?php endif; ?>

    <!-- LANGKAH 3: Input & Daftar Nilai -->
    <?php if (isset($id_kelas) && isset($id_ta) && isset($id_mapel)): ?>
        <div class="mb-4">
            <a href="<?= base_url('nilai?&id_kelas='.$id_kelas.'&id_ta='.$id_ta) ?>" class="btn btn-secondary mb-4">
                ← Kembali ke Pilih Mapel
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- FORM INPUT NILAI -->
            <div class="intro-y box p-5 w-full overflow-auto lg:col-span-1">
                <h2 class="font-medium text-lg mb-4">Input Nilai</h2>
                <?php if(!empty($siswa) && !empty($mapel_terpilih)): ?>
                    <form action="<?= base_url('nilai/save') ?>" method="POST">
                        <input type="hidden" name="id_kelas" value="<?= $id_kelas ?>">
                        <input type="hidden" name="id_ta" value="<?= $id_ta ?>">
                        <input type="hidden" name="id_mapel" value="<?= $id_mapel ?>">

                        <table class="table table-striped w-full mb-4">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Siswa</th>
                                    <?php foreach($mapel_terpilih->komponen as $komponen): ?>
                                        <th><?= htmlspecialchars($komponen['nama_komponen']) ?></th>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no=1; foreach($siswa as $s): ?>
                                    <tr>
                                        <td><?= $no++ ?></td>
                                        <td><?= htmlspecialchars($s->nama) ?></td>
                                        <?php foreach($mapel_terpilih->komponen as $komponen): ?>
                                            <td>
                                                <div class="form-inline flex flex-col">
                                                    <input type="number" step="0.01" min="0" max="100"
                                                        name="nilai[<?= $s->id_enroll ?>][<?= $mapel_terpilih->id_kelas_mapel ?>][<?= $komponen['id_komponen'] ?>]"
                                                        value="<?= $this->Nilai_model->get_nilai_satu($s->id_enroll, $mapel_terpilih->id_mapel, $komponen['id_komponen']) ?>"
                                                        class="form-input w-24 text-center">
                                                </div>
                                            </td>
                                        <?php endforeach; ?>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>

                        <button type="submit" class="btn btn-primary w-full">Simpan Nilai</button>
                    </form>
                <?php else: ?>
                    <p class="text-gray-600">Data tidak tersedia.</p>
                <?php endif; ?>
            </div>

            <!-- DAFTAR NILAI (HANYA UNTUK MAPEL YANG DIPILIH) -->
            <div class="intro-y box p-5 w-full overflow-auto lg:col-span-2">
                <h2 class="font-medium text-lg mb-4">Daftar Nilai: <?= htmlspecialchars($mapel_terpilih->nama_mapel ?? '—') ?></h2>
                <?php 
                $nilai_filtered = array_filter($nilai_terisi, function($n) use ($id_mapel) {
                    return $n->id_mapel == $id_mapel;
                });
                ?>
                <?php if (!empty($nilai_filtered)): ?>
                    <table class="table table-striped w-full" id="nilai_terisi">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Siswa</th>
                                <th>Komponen</th>
                                <th>Skor</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no=1; foreach($nilai_filtered as $n): ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($n->nama) ?></td>
                                    <td><?= htmlspecialchars($n->nama_komponen) ?></td>
                                    <td><?= $n->skor ?></td>
                                    <td>
                                        <a href="<?= base_url('nilai/edit/'.$n->id_nilai) ?>" class="btn btn-warning btn-sm">Edit</a>
                                        <a href="<?= base_url('nilai/delete/'.$n->id_nilai) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p class="text-gray-600">Belum ada nilai yang diinput untuk mapel ini.</p>
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
$(document).ready(function(){
    $('#nilai_terisi').DataTable({ "pageLength": 50 });
});
</script>