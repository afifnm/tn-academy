<div class="p-4">
    <!-- Filter -->
<div class="intro-y col-span-12 flex flex-wrap xl:flex-nowrap items-center mt-2 mb-5">
    <!-- Pilihan Tahun Ajaran & Kelas -->
    <div class="flex w-full sm:w-auto">
        <div class="w-52 relative text-slate-500">
            <select name="id_ta" class="form-select box w-52">
                <option value="">-- Pilih Tahun Ajaran --</option>
                <?php foreach ($tahun_ajaran as $ta): ?>
                    <option value="<?= $ta['id_ta']; ?>" 
                        <?= isset($filter['id_ta']) && $filter['id_ta'] == $ta['id_ta'] ? 'selected' : '' ?>>
                        <?= $ta['tahun'] ?> - <?= $ta['semester'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="w-40 relative text-slate-500 ml-2">
            <select name="id_kelas" class="form-select box w-40">
                <option value="">-- Pilih Kelas --</option>
                <?php foreach ($kelas as $k): ?>
                    <option value="<?= $k['id_kelas']; ?>" 
                        <?= isset($filter['id_kelas']) && $filter['id_kelas'] == $k['id_kelas'] ? 'selected' : '' ?>>
                        <?= $k['nama_kelas'] ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary shadow-md ml-2">Tampilkan</button>
    </div>

    <!-- Info tambahan di tengah (opsional) -->
    <div class="hidden xl:block mx-auto text-slate-500">
        <?php if (!empty($enrolled)): ?>
            Showing <?= count($enrolled) ?> siswa sudah enroll
        <?php endif; ?>
    </div>

    <!-- Tombol Export (opsional) -->
    <div class="w-full xl:w-auto flex items-center mt-3 xl:mt-0">
        <button class="btn btn-primary shadow-md mr-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="lucide lucide-file-text w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V7.5L14.5 2z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><line x1="10" y1="9" x2="8" y2="9"></line></svg>
            Export Excel
        </button>
        <button class="btn btn-primary shadow-md">
            <svg xmlns="http://www.w3.org/2000/svg" class="lucide lucide-file-text w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.5 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V7.5L14.5 2z"></path><polyline points="14 2 14 8 20 8"></polyline><line x1="16" y1="13" x2="8" y2="13"></line><line x1="16" y1="17" x2="8" y2="17"></line><line x1="10" y1="9" x2="8" y2="9"></line></svg>
            Export PDF
        </button>
    </div>
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
