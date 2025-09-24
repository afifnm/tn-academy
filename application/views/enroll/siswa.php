<div class="p-6">
    <!-- Filter -->
    <div class="intro-y box p-5 mb-6">
        <h2 class="text-lg font-medium mb-4">Pilih Kelas & Tahun Ajaran Enroll Siswa</h2>
        <form method="GET" action="<?= base_url('admin/enrollsiswa/filter') ?>" 
              class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="form-label">Tahun Ajaran</label>
                <select name="id_ta" class="form-control w-full">
                    <option value="">-- Pilih Tahun Ajaran --</option>
                    <?php foreach ($tahun_ajaran as $ta): ?>
                        <option value="<?= $ta['id_ta']; ?>" 
                            <?= isset($filter['id_ta']) && $filter['id_ta'] == $ta['id_ta'] ? 'selected' : '' ?>>
                            <?= $ta['tahun'] ?> - <?= $ta['semester'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="form-label">Kelas</label>
                <select name="id_kelas" class="form-control w-full">
                    <option value="">-- Pilih Kelas --</option>
                    <?php foreach ($kelas as $k): ?>
                        <option value="<?= $k['id_kelas']; ?>" 
                            <?= isset($filter['id_kelas']) && $filter['id_kelas'] == $k['id_kelas'] ? 'selected' : '' ?>>
                            <?= $k['nama_kelas'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="flex items-end">
                <button type="submit" class="btn btn-primary w-full">Tampilkan</button>
            </div>
        </form>
    </div>

    <!-- Dua Kolom -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        <!-- Siswa Sudah Enroll -->
        <div class="intro-y box p-5 w-full overflow-auto">
            <h2 class="text-lg font-medium mb-4">Siswa Sudah Enroll</h2>
            <table class="table table-bordered w-full">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NISN</th>
                        <th>Nama</th>
                        <th>Kelas</th>
                        <th>Tahun Ajaran</th>
                        <th>Tanggal Enroll</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($enrolled)): ?>
                        <?php $no = 1; foreach ($enrolled as $row): ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $row['nisn']; ?></td>
                                <td><?= $row['nama']; ?></td>
                                <td><?= $row['nama_kelas']; ?></td>
                                <td><?= $row['tahun']; ?> - <?= $row['semester']; ?></td>
                                <td><?= $row['tanggal_enroll']; ?></td>
                                <td>
                                    <a href="<?= base_url('admin/enrollsiswa/delete/'.$row['id_enroll']); ?>" 
                                       class="btn btn-danger btn-sm"
                                       onclick="return confirm('Hapus siswa dari enroll?')">Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="7" class="text-center">Belum ada siswa di kelas ini.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Siswa Belum Enroll -->
        <div class="intro-y box p-5 w-full overflow-auto">
            <h2 class="text-lg font-medium mb-4">Siswa Belum Enroll</h2>
            <form method="POST" action="<?= base_url('admin/enrollsiswa/enroll_bulk') ?>">
                <input type="hidden" name="id_ta" value="<?= $filter['id_ta'] ?? '' ?>">
                <input type="hidden" name="id_kelas" value="<?= $filter['id_kelas'] ?? '' ?>">

                <table class="table table-bordered w-full">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="checkAll" class="mr-2">Pilih</th>
                            <th>NISN</th>
                            <th>Nama</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($not_enrolled)): ?>
                            <?php foreach ($not_enrolled as $s): ?>
                                <tr>
                                    <td><input type="checkbox" name="siswa_ids[]" value="<?= $s['id_siswa'] ?>"></td>
                                    <td><?= $s['nisn']; ?></td>
                                    <td><?= $s['nama']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="3" class="text-center">Semua siswa sudah enroll.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <button type="submit" class="btn btn-success mt-3 w-full">Enroll Siswa Terpilih</button>
            </form>
        </div>
    </div>
</div>

<script>
    // Checkbox "Pilih Semua"
    document.getElementById('checkAll').addEventListener('click', function() {
        let checkboxes = document.querySelectorAll('input[name="siswa_ids[]"]');
        for (let checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    });
</script>
