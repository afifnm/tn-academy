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
                                    <?php foreach($mapel_terpilih->komponen as $komponen): ?>
                                        <?php if (isset($data['nilai'][$komponen['id_komponen']])): ?>
                                            <a class="flex text-blue-500 mr-4" href="javascript:;" 
                                               data-tw-toggle="modal" data-tw-target="#editNilai<?= $data['id_nilai'][$komponen['id_komponen']] ?>">
                                                <i data-lucide="edit" class="w-4 h-4 mr-1"></i>Edit
                                            </a>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                    
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

                        <!-- Modal Edit Nilai (di dalam loop) -->
                        <?php foreach($mapel_terpilih->komponen as $komponen): ?>
                            <?php if (isset($data['nilai'][$komponen['id_komponen']])): ?>
                                <div id="editNilai<?= $data['id_nilai'][$komponen['id_komponen']] ?>" class="modal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h2 class="font-medium text-base mr-auto">Edit Nilai</h2>
                                            </div>
                                            <form action="<?= base_url('nilai/update') ?>" method="post">
                                                <div class="modal-body">
                                                    <input type="hidden" name="id_nilai" value="<?= $data['id_nilai'][$komponen['id_komponen']] ?>">

                                                    <div>
                                                        <label class="form-label">Siswa</label>
                                                        <input type="text" class="form-control" 
                                                               value="<?= htmlspecialchars($data['siswa']) ?>" readonly>
                                                    </div>
                                                    <div class="mt-3">
                                                        <label class="form-label">Komponen</label>
                                                        <input type="text" class="form-control" 
                                                               value="<?= htmlspecialchars($komponen['nama_komponen']) ?>" readonly>
                                                    </div>
                                                    <div class="mt-3">
                                                        <label class="form-label">Nilai</label>
                                                        <input type="number" step="0.01" min="0" max="100" 
                                                               class="form-control" name="skor" 
                                                               value="<?= $data['nilai'][$komponen['id_komponen']] ?>" required>
                                                    </div>
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
                            <?php endif; ?>
                        <?php endforeach; ?>
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