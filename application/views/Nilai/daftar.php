<div class="p-4">
    <h2 class="font-medium text-base mb-4">Daftar Nilai</h2>

    <div class="intro-y box p-5">
        <h3 class="font-medium text-lg mb-4">Mapel:<?= htmlspecialchars($mapel_terpilih->nama_mapel ?? '—') ?></h3>

        <div class="overflow-x-auto">
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
                    <?php $no=1; foreach($nilai_terisi as $n): ?>
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
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
    $('#nilai_terisi').DataTable({ "pageLength": 50 });
});
</script>