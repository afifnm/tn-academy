<div class="p-4">
    <!-- Filter -->
    <form method="GET" action="<?= base_url('admin/enrollsiswa/filter') ?>">
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

            <!-- Info tambahan -->
            <div class="hidden xl:block mx-auto text-slate-500">
                <?php if (!empty($enrolled)): ?>
                    Showing <?= count($enrolled) ?> siswa sudah enroll
                <?php endif; ?>
            </div>
            <?php if(!empty($filter)): ?>
            <?php if ($enrolled): ?>
            <!-- Tombol Export (opsional) -->
            <div class="w-full xl:w-auto flex items-center mt-3 xl:mt-0">
                <button type="button" class="btn btn-primary shadow-md" data-tw-toggle="modal" data-tw-target="#filterModal">Clone Kelas > Tahun Ajaran</button>
            </div>
            <?php endif; ?>
            <?php endif; ?>
        </div>
    </form>

    <!-- Modal Filter -->
    <div id="filterModal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Clone Kelas Ke Tahun Ajaran</h2>
                    <button type="button" class="btn-close" data-tw-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="cloneForm" method="POST" action="<?= base_url('admin/enrollsiswa/clone') ?>">
                        <div class="mb-3">
                            <label class="form-label">Tahun Ajaran Tujuan</label>
                            <input type="hidden" name="source_ta" value="<?= $filter['id_ta'] ?>">
                            <select name="target_ta" class="form-select" required>
                                <option value="">-- Pilih Tahun Ajaran --</option>
                                <?php foreach ($tahun_ajaran as $ta): ?>
                                    <option value="<?= $ta['id_ta']; ?>">
                                        <?= $ta['tahun'] ?> - <?= $ta['semester'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kelas Tujuan</label>
                            <input type="hidden" name="source_kelas" value="<?= $filter['id_kelas'] ?>">
                            <select name="target_kelas" class="form-select" required>
                                <option value="">-- Pilih Kelas --</option>
                                <?php foreach ($kelas as $k): ?>
                                    <option value="<?= $k['id_kelas']; ?>">
                                        <?= $k['nama_kelas'] ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-tw-dismiss="modal">Batal</button>
                    <button type="submit" form="cloneForm" class="btn btn-primary">Clone</button>
                </div>
            </div>
        </div>
    </div>
    <?php if(!empty($filter)): ?>
    <!-- Dua Kolom -->
    <div class="grid grid-cols-3 gap-6">
        <!-- Siswa Sudah Enroll -->
        <div class="intro-y box p-5 w-full overflow-auto col-span-2">
            <h2 class="text-lg font-medium mb-4">Siswa Sudah Enroll</h2>
            <table id="tblEnrolled" class="table datatable w-full">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIS</th>
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
                                <td><?= $row['nis']; ?></td>
                                <td><?= $row['nama']; ?></td>
                                <td><?= $row['nama_kelas']; ?></td>
                                <td><?= $row['tahun']; ?> - <?= $row['semester']; ?></td>
                                <td><?= $row['tanggal_enroll']; ?></td>
                                <td>
                                    <a class="flex text-danger delete-btn" href="javascript:;" 
                                        onclick="confirmDelete('<?= site_url('admin/enrollsiswa/delete/'.$row['id_enroll']) ?>')">
                                        <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete
                                    </a>
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
        <div class="intro-y box p-5 w-full overflow-auto col-span-1">
            <h2 class="text-lg font-medium mb-4">Siswa Belum Enroll</h2>
            <form method="POST" action="<?= base_url('admin/enrollsiswa/enroll_bulk') ?>">
                <input type="hidden" name="id_ta" value="<?= $filter['id_ta'] ?? '' ?>">
                <input type="hidden" name="id_kelas" value="<?= $filter['id_kelas'] ?? '' ?>">

                <table id="tblNotEnrolled" class="table datatable w-full">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="checkAll" class="mr-2">Pilih</th>
                            <th>NIS</th>
                            <th>Nama</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($not_enrolled)): ?>
                            <?php foreach ($not_enrolled as $s): ?>
                                <tr>
                                    <td><input type="checkbox" name="siswa_ids[]" value="<?= $s['id_siswa'] ?>"></td>
                                    <td><?= $s['nis']; ?></td>
                                    <td><?= $s['nama']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="3" class="text-center">Semua siswa sudah enroll.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <button type="submit" class="btn btn-primary mt-3 w-full">Enroll Siswa Terpilih</button>
            </form>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
    // Checkbox "Pilih Semua"
    document.getElementById('checkAll').addEventListener('click', function() {
        let checkboxes = document.querySelectorAll('input[name="siswa_ids[]"]');
        for (let checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    });

    // DataTables init untuk semua tabel dengan class .datatable
    $(document).ready(function () {
        $('#tblEnrolled').DataTable({
            pageLength: 50,
            responsive: true,
            language:{
                emptyTable: "Tidak ada data tersedia pada tabel ini",
            }
        });
    });

     $(document).ready(function () {
        $('#tblNotEnrolled').DataTable({
            pageLength: 50,
            responsive: true,
            language:{
                emptyTable: "Tidak ada data tersedia pada tabel ini",
            }
        });
    });
</script>
