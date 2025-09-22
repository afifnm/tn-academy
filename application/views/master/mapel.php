<h2 class="intro-y text-lg font-medium">List Mata Pelajaran</h2>

<!-- Tombol Tambah -->
<div class="text-left mt-5">
    <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#addMapel" class="btn btn-primary">
        Tambah Mata Pelajaran
    </a>
</div>

<!-- Box List Mapel -->
<div class="intro-y box mt-3">
    <div class="p-5">
        <div class="preview">
            <div class="overflow-x-auto">
                <table id="example1" class="table table-report table-report--bordered display datatable w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="text-center border-b-2">NO</th>
                            <th class="text-left border-b-2">MATA PELAJARAN</th>
                            <th class="text-center border-b-2">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach ($mapel as $ma) { ?>
                        <tr>
                            <td class="text-center border-b"><?= $no ?></td>
                            <td class="text-left border-b"><?= $ma['nama_mapel'] ?></td>
                            <td class="border-b">
                                <div class="flex justify-center items-center space-x-3">
                                    <!-- Edit -->
                                    <a class="flex items-center text-blue-500" href="javascript:;" 
                                       data-tw-toggle="modal" data-tw-target="#edit<?= $ma['id_mapel'] ?>">
                                        <i data-lucide="edit" class="w-4 h-4 mr-1"></i> Edit
                                    </a>

                                    <!-- Delete -->
                                    <a href="javascript:;" data-tw-toggle="modal" 
                                       data-tw-target="#delete-confirmation-modal"
                                       data-url="<?= site_url('admin/mapel/delete/'.$ma['id_mapel']) ?>"
                                       class="flex items-center text-danger">
                                        <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div id="edit<?= $ma['id_mapel'] ?>" class="modal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h2 class="font-medium text-base mr-auto">Edit Mata Pelajaran</h2>
                                    </div>
                                    <form action="<?= base_url('admin/mapel/edit') ?>" method="post">
                                        <div class="modal-body">
                                            <input type="hidden" name="id_mapel" value="<?= $ma['id_mapel'] ?>">
                                            <div>
                                                <label class="form-label">Nama Mata Pelajaran</label>
                                                <input type="text" class="form-control" name="nama_mapel" 
                                                       value="<?= $ma['nama_mapel'] ?>" required>
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
                        <!-- End Modal Edit -->

                        <?php $no++; } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add Mapel -->
<div id="addMapel" class="modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="font-medium text-base mr-auto">Tambah Mata Pelajaran</h2>
      </div>
      <form action="<?= base_url('admin/mapel/add') ?>" method="post">
        <div class="modal-body">
          <div>
            <label class="form-label">Nama Mata Pelajaran</label>
            <input type="text" class="form-control" name="nama_mapel" placeholder="Nama Mapel" required>
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
