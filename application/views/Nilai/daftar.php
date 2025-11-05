<div class="p-4">
    <h2 class="font-medium text-base mb-4">Daftar Nilai</h2>

    <div class="intro-y box p-5">
        <h3 class="font-medium text-lg mb-4">Mapel: <?= htmlspecialchars($mapel_terpilih->nama_mapel ?? '—') ?></h3>

        <div class="overflow-x-auto">
            <table class="table table-striped w-full" id="nilai_terisi">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Siswa</th>
                        <?php foreach($mapel_terpilih->komponen as $komponen): ?>
                            <th><?= htmlspecialchars($komponen['nama_komponen']) ?></th>
                        <?php endforeach; ?>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    // Kelompokkan nilai berdasarkan id_enroll (siswa) - hanya untuk mapel ini
                    $nilai_grouped = [];
                    foreach($nilai_terisi as $n) {
                        if ($n->id_mapel == $id_mapel) {
                            $nilai_grouped[$n->id_enroll]['siswa'] = $n->nama;
                            $nilai_grouped[$n->id_enroll]['nilai'][$n->id_komponen] = $n->skor;
                            $nilai_grouped[$n->id_enroll]['id_nilai'][$n->id_komponen] = $n->id_nilai;
                        }
                    }
                    ?>
                    <?php $no = 1; foreach($nilai_grouped as $id_enroll => $data): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><?= htmlspecialchars($data['siswa']) ?></td>
                            <?php foreach($mapel_terpilih->komponen as $komponen): ?>
                                <td>
                                    <?= $data['nilai'][$komponen['id_komponen']] ?? '-' ?>
                                </td>
                            <?php endforeach; ?>
                            <td>
                                <?php 
                                $keys = array_keys($data['nilai']); 
                                $first_key = $keys[0] ?? null; 
                                ?>
                                <?php if ($first_key !== null): ?>
                                    <a href="<?= base_url('nilai/edit/'.$data['id_nilai'][$first_key]) ?>" class="btn btn-warning btn-sm">Edit</a>
                                    <a href="<?= base_url('nilai/delete/'.$data['id_nilai'][$first_key]) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin hapus?')">Hapus</a>
                                <?php else: ?>
                                    -
                                <?php endif; ?>
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