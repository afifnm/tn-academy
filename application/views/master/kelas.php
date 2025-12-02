
<!-- Tombol Tambah -->
<div class="text-left">
    <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#addKelas" class="btn btn-primary">
        Tambah Data Kelas
    </a>
</div>

<!-- Box List Kelas -->
<div class="intro-y box mt-3">
    <div class="p-5">
        <div class="preview">
            <div class="overflow-x-auto">
                <table id="kelasTable" class="table table-auto display datatable w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="w-5">NO</th>
                            <th class="border-b-2">NAMA KELAS</th>
                            <th class="border-b-2">TINGKAT</th>
                            <th class="border-b-2">JURUSAN</th>
                            <?php if($this->session->userdata('role')=='admin'): ?>
                            <th class="border-b-2">AKSI</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach ($kelas as $kel) { ?>
                        <tr>
                            <td><?= $no ?></td>
                            <td><?= $kel['nama_kelas'] ?></td>
                            <td><?= $kel['tingkat'] ?></td>
                            <td><?= $kel['jurusan'] ?></td>
                            <?php if($this->session->userdata('role')=='admin'): ?>
                            <td>
                                <div class="flex space-x-3">
                                    <!-- Edit -->
                                    <a class="flex text-blue-500 mr-4" href="javascript:;" 
                                       data-tw-toggle="modal" data-tw-target="#edit<?= $kel['id_kelas'] ?>">
                                        <i data-lucide="edit" class="w-4 h-4 mr-1"></i>Edit
                                    </a>

                                    <!-- Delete -->
                                   <a class="flex text-danger delete-btn" href="javascript:;" 
                                       onclick="confirmDelete('<?= site_url('admin/kelas/delete/'.$kel['id_kelas']) ?>')">
                                        <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete
                                    </a>
                                </div>
                            </td>
                            <?php endif; ?>
                        </tr>

                        <!-- Modal Edit -->
                        <div id="edit<?= $kel['id_kelas'] ?>" class="modal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h2 class="font-medium text-base mr-auto">Edit Data Kelas</h2>
                                    </div>
                                    <form action="<?= base_url('admin/kelas/edit') ?>" method="post">
                                        <div class="modal-body">
                                            <input type="hidden" name="id_kelas" value="<?= $kel['id_kelas'] ?>">

                                            <div>
                                                <label class="form-label">Nama Kelas</label>
                                                <input type="text" class="form-control" name="nama_kelas" 
                                                       value="<?= $kel['nama_kelas'] ?>" required>
                                            </div>
                                            <div class="mt-3">
                                                <label class="form-label">Tingkat</label>
                                                <select class="form-select" name="tingkat" required>
                                                    <option value="X" <?=($kel['tingkat']=='X')?'selected':''?>>X</option>
                                                    <option value="XI" <?=($kel['tingkat']=='XI')?'selected':''?>>XI</option>
                                                    <option value="XII" <?=($kel['tingkat']=='XII')?'selected':''?>>XII</option>
                                                </select>
                                            </div>
                                            <div class="mt-3">
                                                <label class="form-label">Jurusan</label>
                                                <input type="text" class="form-control" name="jurusan" 
                                                       value="<?= $kel['jurusan'] ?>" required>
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

<!-- Modal Add Kelas -->
<div id="addKelas" class="modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="font-medium text-base mr-auto">Tambah Data Kelas</h2>
      </div>
      <form action="<?= base_url('admin/kelas/add') ?>" method="post">
        <div class="modal-body">
          <div>
            <label class="form-label">Nama Kelas</label>
            <input type="text" class="form-control" name="nama_kelas" placeholder="Nama Kelas" required>
          </div>
          <div class="mt-3">
            <label class="form-label">Tingkat</label>
            <select class="form-select" name="tingkat" required>
                <option value="X">X</option>
                <option value="XI">XI</option>
                <option value="XII">XII</option>
            </select>
          </div>
          <div class="mt-3">
            <label class="form-label">Jurusan</label>
            <input type="text" class="form-control" name="jurusan" placeholder="Jurusan" required>
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

<!-- Script DataTables -->
<script>
    $(document).ready(function () {
        $('#kelasTable').DataTable({
            responsive: true,
            pageLength: 10,
            language: {
                search: "Cari:",
                lengthMenu: "Tampilkan _MENU_ data",
                info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                paginate: {
                    previous: "←",
                    next: "→"
                }
            }
        });
    });
</script>
