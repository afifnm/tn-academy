<div class="p-4">
    <h2 class="font-medium text-base mb-4">Daftar Nilai</h2>

    <div class="intro-y box p-5">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-medium text-lg">Mapel: <?= htmlspecialchars($mapel_terpilih->nama_mapel ?? '—') ?></h3>
            <a href="<?= base_url('nilai?id_kelas='.$id_kelas.'&id_ta='.$id_ta.'&id_mapel='.$id_mapel) ?>" class="btn btn-secondary">
                ← Kembali ke Input Nilai
            </a>
        </div>

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
                                    <?php $nilai = $data['nilai'][$komponen['id_komponen']] ?? null; ?>
                                    <?php if ($nilai !== null): ?>
                                        <?= $nilai ?>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                            <?php endforeach; ?>
                            <td>
                                <div class="flex space-x-3">
                                    <a class="flex text-blue-500 mr-4" href="javascript:;" 
                                       data-tw-toggle="modal" data-tw-target="#editNilai<?= $id_enroll ?>">
                                        <i data-lucide="edit" class="w-4 h-4 mr-1"></i>Edit
                                    </a>
                                    
                                    <?php 
                                    $keys = array_keys($data['nilai']); 
                                    $first_key = $keys[0] ?? null; 
                                    ?>
                                    <?php if ($first_key !== null): ?>
                                        <a class="flex text-danger delete-btn" href="javascript:;" 
                                           onclick="confirmDelete('<?= base_url('nilai/delete/'.$data['id_nilai'][$first_key]) ?>')">
                                            <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete
                                        </a>
                                    <?php endif; ?>
                                </div>
                            </td>
                        </tr>

                        <div id="editNilai<?= $id_enroll ?>" class="modal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h2 class="font-medium text-base mr-auto">Edit Nilai - <?= htmlspecialchars($data['siswa']) ?></h2>
                                    </div>
                                    <form action="<?= base_url('nilai/update_multiple') ?>" method="post">
                                        <div class="modal-body">
                                            <input type="hidden" name="id_enroll" value="<?= $id_enroll ?>">
                                            <input type="hidden" name="id_kelas_mapel" value="<?= $mapel_terpilih->id_kelas_mapel ?>">

                                            <?php foreach($mapel_terpilih->komponen as $komponen): ?>
                                                <div class="flex items-center mt-2">
                                                    <label class="form-label w-24 mr-2"><?= htmlspecialchars($komponen['nama_komponen']) ?>:</label>
                                                    <input type="number" step="0.01" min="0" max="100" 
                                                           class="form-control w-70" 
                                                           name="nilai[<?= $komponen['id_komponen'] ?>]" 
                                                           value="<?= $data['nilai'][$komponen['id_komponen']] ?? '' ?>" required>
                                                </div>
                                            <?php endforeach; ?>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" data-tw-dismiss="modal" 
                                                    class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                                            <button type="submit" class="btn btn-primary w-20">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
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