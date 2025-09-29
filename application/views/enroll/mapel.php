<div class="p-4">
    <!-- Filter -->
    <form method="GET" action="<?= base_url('admin/enrollmapel/filter') ?>">
        <div class="intro-y col-span-12 flex flex-wrap xl:flex-nowrap items-center mt-2 mb-5">
            <div class="flex w-full sm:w-auto">
                <div class="w-52 relative text-slate-500">
                    <select name="id_ta" class="form-select box w-52">
                        <option value="">-- Pilih Tahun Ajaran --</option>
                        <?php foreach ($tahun_ajaran as $ta): ?>
                            <option value="<?= $ta['id_ta']; ?>" 
                                <?= isset($filter['id_ta']) && $filter['id_ta'] == $ta['id_ta'] ? 'selected' : '' ?>>
                                <?= $ta['tahun']; ?> - <?= $ta['semester']; ?>
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
                                <?= $k['nama_kelas']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary shadow-md ml-2">Tampilkan</button>
            </div>

            <div class="hidden xl:block mx-auto text-slate-500">
                <?php if (!empty($enrolled)): ?>
                    Showing <?= count($enrolled) ?> mapel sudah enroll
                <?php endif; ?>
            </div>
        </div>
    </form>

    <!-- Dua Kolom -->
    <div class="grid grid-cols-3 gap-6">
        
        <!-- Mapel Sudah Enroll -->
        <div class="intro-y box p-5 w-full overflow-auto col-span-2">
            <h2 class="text-lg font-medium mb-4">Mapel Sudah Enroll</h2>
            <table class="table datatable w-full table-auto" id="tblEnrolledM">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Mapel</th>
                        <th>Kelas</th>
                        <th>Tahun Ajaran</th>
                        <th>Semester</th>
                        <th>Komponen</th>
                        <th>Tanggal Enroll</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($enrolled)): ?>
                        <?php $no = 1; foreach ($enrolled as $row): ?>
                            <?php $komponen = $this->EnrollMapel_model->get_komponen($row['id_enroll_mapel']); ?>
                            <tr>
                                <td><?= $no++; ?></td>
                                <td><?= $row['nama_mapel']; ?></td>
                                <td><?= $row['nama_kelas']; ?></td>
                                <td><?= $row['tahun']; ?></td>
                                <td><?= $row['semester']; ?></td>
                                <td>
                                    <?php if (!empty($komponen)): ?>
                                        <ul class="list-disc ml-4">
                                        <?php foreach ($komponen as $k): ?>
                                            <li><?= $k['nama_komponen']; ?> (<?= $k['bobot']; ?>)</li>
                                        <?php endforeach; ?>
                                        </ul>
                                    <?php else: ?>
                                        -
                                    <?php endif; ?>
                                </td>
                                <td><?= $row['tanggal_enroll']; ?></td>
                                <td>
                                    <a class="flex text-danger delete-btn" href="javascript:;" 
                                        onclick="confirmDelete('<?= site_url('admin/enrollmapel/delete/'.$row['id_enroll_mapel']) ?>')">
                                        <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="8" class="text-center">Belum ada mapel di kelas ini.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Mapel Belum Enroll -->
        <div class="intro-y box p-5 w-full overflow-auto col-span-1">
            <h2 class="text-lg font-medium mb-4">Mapel Belum Enroll</h2>
            <form method="POST" action="<?= base_url('admin/enrollmapel/enroll_bulk') ?>">
                <input type="hidden" name="id_ta" value="<?= $filter['id_ta'] ?? '' ?>">
                <input type="hidden" name="id_kelas" value="<?= $filter['id_kelas'] ?? '' ?>">

                <table class="table datatable w-full table-auto" id="tblNotEnrolledM">
                    <thead>
                        <tr>
                            <th><input type="checkbox" id="checkAllMapel" class="mr-2">Pilih</th>
                            <th>Nama Mapel</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($not_enrolled)): ?>
                            <?php foreach ($not_enrolled as $m): ?>
                                <tr>
                                    <td><input type="checkbox" name="mapel_ids[]" value="<?= $m['id_mapel'] ?>"></td>
                                    <td><?= $m['nama_mapel']; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="2" class="text-center">Semua mapel sudah enroll.</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
                <button type="submit" class="btn btn-primary mt-3 w-full">Enroll Mapel Terpilih</button>
            </form>
        </div>

    </div>
</div>

<script>
    // Checkbox "Pilih Semua" untuk mapel
    document.getElementById('checkAllMapel').addEventListener('click', function() {
        let checkboxes = document.querySelectorAll('input[name="mapel_ids[]"]');
        for (let checkbox of checkboxes) {
            checkbox.checked = this.checked;
        }
    });

    // DataTables init untuk semua tabel dengan class .datatable
    $(document).ready(function () {
        $('#tblEnrolledM').DataTable({
            pageLength: 50,
            responsive: true,
            language:{
                emptyTable: "Tidak ada data tersedia pada tabel ini",
            }
        });
    });

     $(document).ready(function () {
        $('#tblNotEnrolledM').DataTable({
            pageLength: 50,
            responsive: true,
            language:{
                emptyTable: "Tidak ada data tersedia pada tabel ini",
            }
        });
    });
   
</script>
