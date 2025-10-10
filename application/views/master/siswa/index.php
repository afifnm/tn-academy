
<!-- Tombol Tambah -->
<div class="flex items-center justify-between mb-4">
    <div class="flex items-center gap-2">
        <!-- Tombol Tambah Data Siswa -->
        <a href="<?=base_url('admin/siswa/add')?>" class="btn btn-primary">
            Tambah Data Siswa
        </a>

        <!-- Tombol Import Excel -->
        <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#importExcel" class="btn btn-success">
            Import Excel
        </a>
    </div>
    
</div>

<!-- Box List Siswa -->
<div class="intro-y box mt-4">
    <div class="p-5">
        <div class="preview">
            <div class="overflow-x-auto">
                <!-- Filter Tahun Masuk -->
                <div class="mb-4">
                    <form action="<?= base_url('admin/siswa') ?>" method="get" class=" gap-3">
                        <label for="thn_masuk" class="font-medium text-gray-700">Filter Tahun Masuk:</label>
                        <select name="thn_masuk" id="thn_masuk" class="form-select w-44" onchange="this.form.submit()">
                        <option value="">Pilih Tahun Masuk</option>
                        <?php foreach ($daftar_thn as $t): ?>
                            <option value="<?= $t['thn_masuk'] ?>" <?= ($t['thn_masuk'] == $thn_masuk) ? 'selected' : '' ?>>
                            <?= $t['thn_masuk'] ?>
                            </option>
                        <?php endforeach; ?>
                        </select>
                        <?php if ($thn_masuk): ?>
                        <a href="<?= base_url('admin/siswa') ?>" class="btn btn-outline-secondary ml-2">Reset</a>
                        <?php endif; ?>
                    </form>
                </div>

                <table id="example1" class="table table-report table-report--bordered display datatable w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th>NO</th>
                            <th>NISN</th>
                            <th>NIS</th>
                            <th>NAMA</th>
                            <th>JALUR PENDIDIKAN</th>
                            <th>TAHUN MASUK</th>
                            <th>STATUS</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($siswa)): ?>
                        <tr>
                            <td colspan="8" class="text-center text-slate-500 py-4">
                            Pilih tahun masuk untuk menampilkan data.
                            </td>
                        </tr>
                        <?php else: ?>
                            <?php $no=1+ ($offset ?? 0); foreach ($siswa as $sis) { ?>
                            <tr>
                                <td><?= $no ?></td>
                                <td><?= $sis['nisn'] ?></td>
                                <td><?= $sis['nis'] ?></td>
                                <td><?= $sis['nama'] ?></td>
                                <td><?= $sis['jalur_pendidikan'] ?></td>
                                <td><?= $sis['thn_masuk'] ?></td>
                                <td><?= $sis['status'] ?></td>
                                <td>
                                    <div class="flex space-x-15">
                                        <!-- Detail -->
                                        <a class="flex text-blue-500 mr-4" href="<?= base_url('admin/siswa/detail/'.$sis['id_siswa']) ?>" >
                                            <i data-lucide="external-link" class="w-4 h-4 mr-1"></i> Detail
                                        </a>

                                        <!-- Edit
                                        <a class="flex text-blue-500 mr-4" href="javascript:      ;" 
                                        data-tw-toggle="modal" data-tw-target="#edit<?= $sis['id_siswa'] ?>">
                                            <i data-lucide="edit" class="w-4 h-4 mr-1"></i> Edit
                                        </a> -->

                                        <!-- Delete -->
                                    <a class="flex text-danger delete-btn" href="javascript:;" 
                                        onclick="confirmDelete('<?= site_url('admin/siswa/delete/'.$sis['id_siswa']) ?>')">
                                            <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            <!-- Modal Edit -->
                            <div id="edit<?= $sis['id_siswa'] ?>" class="modal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="font-medium text-base mr-auto">Edit Data Siswa</h2>
                                        </div>
                                        <form action="<?= base_url('admin/siswa/edit') ?>" method="post">
                                            <div class="modal-body">
                                                <input type="hidden" name="id_siswa" value="<?= $sis['id_siswa'] ?>">

                                                <div>
                                                    <label class="form-label">NISN</label>
                                                    <input type="text" class="form-control" name="nisn" 
                                                        value="<?= $sis['nisn'] ?>" required>
                                                </div>
                                                <div class="mt-3">
                                                    <label class="form-label">Nama Siswa</label>
                                                    <input type="text" class="form-control" name="nama" 
                                                        value="<?= $sis['nama'] ?>" required>
                                                </div>
                                                <div class="mt-3">
                                                    <label class="form-label">Tanggal Lahir</label>
                                                    <input type="text" class="datepicker form-control" data-single-mode="true"
                                                        name="tgl_lahir" value="<?= $sis['tgl_lahir'] ?>" required>
                                                </div>
                                                <div class="mt-3">
                                                    <label class="form-label">Tahun Masuk</label>
                                                    <input type="number" class="form-control" name="thn_masuk" 
                                                        value="<?= $sis['thn_masuk'] ?>" required>
                                                </div>
                                                <div class="mt-3">
                                                    <label class="form-label">Status</label>
                                                    <select class="form-select" name="status" required>
                                                        <option value="aktif" <?=($sis['status']=='aktif')?'selected':''?>>Aktif</option>
                                                        <option value="lulus" <?=($sis['status']=='lulus')?'selected':''?>>Lulus</option>
                                                        <option value="keluar" <?=($sis['status']=='keluar')?'selected':''?>>Keluar</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                                                <button type="submit" class="btn btn-primary w-20">Save</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- End Modal Edit -->

                            <?php $no++; } ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<!-- BEGIN: Modal Import Excel -->
<div id="importExcel" class="modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <!-- Header -->
      <div class="modal-header">
        <h2 class="font-medium text-base mr-auto">Import Data Siswa dari Excel</h2>
      </div>

      <!-- Form -->
      <form action="<?= base_url('admin/siswa/importExcel') ?>" method="post" enctype="multipart/form-data">
        <div class="modal-body">
          <div>
            <label class="form-label">File Excel</label>
            <input 
              type="file" 
              class="form-control" 
              name="file_excel" 
              accept=".xls,.xlsx"
              placeholder="Pilih file Excel" 
              required
            >
          </div>
        </div>

        <!-- Footer -->
        <div class="modal-footer">
          <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
          <button type="submit" class="btn btn-success w-24">Import</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- END: Modal Import Excel -->


