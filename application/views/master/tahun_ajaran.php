<h2 class="intro-y text-lg font-medium">List Tahun Ajaran</h2>

<!-- Tombol Tambah -->
<div class="text-left mt-5">
    <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#tambahTA" class="btn btn-primary shadow-md">
        Tambah Data Tahun Ajaran
    </a>
</div>

<!-- Box List Tahun Ajaran -->
<div class="intro-y box mt-3">
    <div class="p-5">
        <div class="preview">
            <div class="overflow-x-auto">
                <table id="example1" class="table table-auto display datatable w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border-b-2">NO</th>
                            <th class="border-b-2">TAHUN AJARAN</th>
                            <th class="border-b-2">SEMESTER</th>
                            <th class="border-b-2">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach ($tahun_ajaran as $ta) { ?>
                        <tr>
                            <td class="border-b"><?= $no ?></td>
                            <td class="border-b"><?= $ta['tahun'] ?></td>
                            <td class="border-b"><?= $ta['semester'] ?></td>
                            <td class="border-b">
                                <div class="flex space-x-3">
                                    <!-- Edit -->
                                    <a class="flex text-blue-500 mr-4" href="javascript:;" 
                                       data-tw-toggle="modal" data-tw-target="#edit<?= $ta['id_ta'] ?>">
                                        <i data-lucide="edit" class="w-4 h-4 mr-1"></i> Edit
                                    </a>

                                    <!-- Delete -->
                                    <a class="flex text-danger delete-btn" href="javascript:;" 
                                       onclick="confirmDelete('<?= site_url('admin/tahun_ajaran/delete/'.$ta['id_ta']) ?>')">
                                        <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div id="edit<?= $ta['id_ta'] ?>" class="modal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h2 class="font-medium text-base mr-auto">Edit Data Tahun Ajaran</h2>
                                    </div>
                                    <form action="<?= base_url('admin/tahun_ajaran/edit') ?>" method="post">
                                        <div class="modal-body">
                                            <input type="hidden" name="id_ta" value="<?= $ta['id_ta'] ?>">

                                            <div>
                                                <label class="form-label">Tahun Ajaran</label>
                                                <input type="text" class="form-control" name="tahun" 
                                                       placeholder="0000/0000"
                                                       value="<?= $ta['tahun'] ?>" required>
                                            </div>
                                            <div class="mt-3">
                                                <label class="form-label">Semester</label>
                                                <select class="form-select" name="semester" required>
                                                    <option value="Ganjil" <?=($ta['semester']=='Ganjil')?'selected':''?>>Ganjil</option>
                                                    <option value="Genap" <?=($ta['semester']=='Genap')?'selected':''?>>Genap</option>
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

<!-- Modal Add Tahun Ajaran -->
<div id="tambahTA" class="modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="font-medium text-base mr-auto">Tambah Data Tahun Ajaran</h2>
      </div>
      <form action="<?= base_url('admin/tahun_ajaran/add') ?>" method="post">
        <div class="modal-body">
          <div>
            <label class="form-label">Tahun Ajaran</label>
            <input type="text" class="form-control" name="tahun" placeholder="0000/0000" required>
          </div>
          <div class="mt-3">
            <label class="form-label">Semester</label>
            <select class="form-select" name="semester" required>
              <option value="Ganjil">Ganjil</option>
              <option value="Genap">Genap</option>
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
