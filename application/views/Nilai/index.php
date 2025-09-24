<div class="p-4">

    <!-- Form Filter Kelas, Tahun Ajaran, dan Mapel -->
    <form method="GET" class="flex gap-4 mb-6">
        <select name="id_kelas" class="form-select w-48">
            <option value="">-- Pilih Kelas --</option>
            <?php foreach($kelas as $k): ?>
                <option value="<?= $k['id_kelas'] ?>" <?= (isset($id_kelas) && $id_kelas==$k['id_kelas'])?'selected':'' ?>>
                    <?= $k['nama_kelas'] ?>
                </option>
            <?php endforeach; ?>
        </select>

        <select name="id_ta" class="form-select w-48">
            <option value="">-- Pilih Tahun Ajaran --</option>
            <?php foreach($tahun_ajaran as $ta): ?>
                <option value="<?= $ta->id_ta ?>" <?= (isset($id_ta) && $id_ta==$ta->id_ta)?'selected':'' ?>>
                    <?= $ta->tahun ?> - <?= $ta->semester ?>
                </option>
            <?php endforeach; ?>
        </select>

        <select name="id_mapel" class="form-select w-48">
            <option value="">-- Pilih Mapel --</option>
            <?php foreach($mapel as $m): ?>
                <option value="<?= $m->id_mapel ?>" <?= (isset($id_mapel) && $id_mapel==$m->id_mapel)?'selected':'' ?>>
                    <?= $m->nama_mapel ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button class="btn btn-primary h-10 mt-1">Tampilkan Nilai</button>
    </form>

    <div class="grid grid-cols-3 gap-6">

        <!-- FORM INPUT NILAI -->
        <div class="intro-y box p-5 w-full overflow-auto col-span-1">
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
                                <th><?= $komponen->nama_komponen ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach($siswa as $s): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $s->nama ?></td>
                                <?php foreach($mapel_terpilih->komponen as $komponen): ?>
                                    <td>
                                        <div class="form-inline flex flex-col">
                                            <label class="text-xs mb-1"><?= $komponen->nama_komponen ?></label>
                                            <input type="number" step="0.01" min="0" max="100"
                                                name="nilai[<?= $s->id_enroll ?>][<?= $mapel_terpilih->id_kelas_mapel ?>][<?= $komponen->id_komponen ?>]"
                                                class="form-input w-24 text-center">
                                        </div>
                                    </td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

                <button type="submit" class="btn btn-primary mt-2">Simpan Nilai</button>
            </form>
            <?php else: ?>
                <p>Pilih kelas, tahun ajaran, dan mapel terlebih dahulu.</p>
            <?php endif; ?>
        </div>

        <!-- DAFTAR NILAI -->
        <div class="intro-y box p-5 w-full overflow-auto col-span-2">
            <h2 class="font-medium text-lg mb-4">Daftar Nilai</h2>
            <table class="table table-striped w-full" id="nilai_terisi">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Siswa</th>
                        <th>Mapel</th>
                        <th>Komponen</th>
                        <th>Skor</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no=1; foreach($nilai_terisi as $n): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= $n->nama ?></td>
                            <td><?= $n->nama_mapel ?></td>
                            <td><?= $n->nama_komponen ?></td>
                            <td><?= $n->skor ?></td>
                            <td>
                                <a href="<?= base_url('nilai/edit/'.$n->id_nilai) ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="<?= base_url('nilai/delete/'.$n->id_nilai) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $('#nilai_terisi').DataTable({ "pageLength": 50 });
});
</script>
