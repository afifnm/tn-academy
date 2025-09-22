<h2 class="intro-y text-lg font-medium">List Data Siswa</h2>

<!-- Tombol Tambah -->
<div class="text-left mt-5">
    <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#addSiswa" class="btn btn-primary">
        Tambah Data Siswa
    </a>
</div>

<!-- Box List Siswa -->
<div class="intro-y box mt-3">
    <div class="p-5">
        <div class="preview">
            <div class="overflow-x-auto">
                <table id="example1" class="table table-report table-report--bordered display datatable w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="text-center border-b-2">NO</th>
                            <th class="text-center border-b-2">NISN</th>
                            <th class="text-left border-b-2">NAMA</th>
                            <th class="text-center border-b-2">TANGGAL LAHIR</th>
                            <th class="text-center border-b-2">TAHUN MASUK</th>
                            <th class="text-center border-b-2">STATUS</th>
                            <th class="text-center border-b-2">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1+ ($offset ?? 0); foreach ($siswa as $sis) { ?>
                        <tr>
                            <td class="text-center border-b"><?= $no ?></td>
                            <td class="text-center border-b"><?= $sis['nisn'] ?></td>
                            <td class="text-left border-b"><?= $sis['nama'] ?></td>
                            <td class="text-center border-b"><?= $sis['tgl_lahir'] ?></td>
                            <td class="text-center border-b"><?= $sis['thn_masuk'] ?></td>
                            <td class="text-center border-b"><?= $sis['status'] ?></td>
                            <td class="border-b">
                                <div class="flex justify-center items-center space-x-3">
                                    <!-- Edit -->
                                    <a class="flex items-center text-blue-500" href="javascript:;" 
                                       data-tw-toggle="modal" data-tw-target="#edit<?= $sis['id_siswa'] ?>">
                                        <i data-lucide="edit" class="w-4 h-4 mr-1"></i> Edit
                                    </a>

                                    <!-- Delete -->
                                    <a href="javascript:;" data-tw-toggle="modal" 
                                       data-tw-target="#delete-confirmation-modal"
                                       data-url="<?= site_url('admin/siswa/delete/'.$sis['id_siswa']) ?>"
                                       class="flex items-center text-danger">
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
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add Siswa -->
<div id="addSiswa" class="modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="font-medium text-base mr-auto">Tambah Data Siswa</h2>
      </div>
      <form action="<?= base_url('admin/siswa/add') ?>" method="post">
        <div class="modal-body">
          <div>
            <label class="form-label">NISN</label>
            <input type="text" class="form-control" name="nisn" placeholder="NISN" required>
          </div>
          <div class="mt-3">
            <label class="form-label">Nama Siswa</label>
            <input type="text" class="form-control" name="nama" placeholder="Nama" required>
          </div>
          <div class="mt-3">
            <label class="form-label">Tanggal Lahir</label>
            <input type="text" class="datepicker form-control" data-single-mode="true" name="tgl_lahir" required>
          </div>
          <div class="mt-3">
            <label class="form-label">Tahun Masuk</label>
            <input type="number" class="form-control" name="thn_masuk" placeholder="Tahun Masuk" min="2000" max="2025" required>
          </div>
          <div class="mt-3">
            <label class="form-label">Status</label>
            <select class="form-select" name="status" required>
              <option value="aktif">Aktif</option>
              <option value="lulus">Lulus</option>
              <option value="keluar">Keluar</option>
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
