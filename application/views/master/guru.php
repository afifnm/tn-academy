
<!-- Tombol Tambah -->
<div class="text-left">
    <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#addGuru" class="btn btn-primary">
        Tambah Data Guru
    </a>
</div>

<!-- Box List Guru -->
<div class="intro-y box mt-3">
    <div class="p-5">
        <div class="preview">
            <div class="overflow-x-auto">
                <table id="guruTable" class="table table-report table-report--bordered display datatable w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border-b-2">NO</th>
                            <th class="border-b-2">NIP GURU</th>
                            <th class="border-b-2">NAMA GURU</th>
                            <th class="border-b-2">EMAIL</th>
                            <th class="border-b-2">PASSWORD</th>
                            <th class="border-b-2">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no=1; foreach ($guru as $gu) { ?>
                        <tr>
                            <td class="border-b"><?= $no ?></td>
                            <td class="border-b"><?= $gu['nip'] ?></td>
                            <td class="border-b"><?= $gu['nama_guru'] ?></td>
                            <td class="border-b"><?= $gu['email_guru'] ?></td>
                            <td class="border-b"><?= $gu['password'] ?></td>
                            <td class="border-b">
                                <div class="flex space-x-3">
                                    <!-- Edit -->
                                    <a class="flex text-blue-500 mr-4" href="javascript:;" 
                                       data-tw-toggle="modal" data-tw-target="#edit<?= $gu['id_guru'] ?>">
                                        <i data-lucide="edit" class="w-4 h-4 mr-1"></i>Edit
                                    </a>

                                   <a class="flex text-danger delete-btn" href="javascript:;" 
                                       onclick="confirmDelete('<?= site_url('admin/guru/delete/'.$gu['id_guru']) ?>')">
                                        <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete
                                    </a>
                                </div>
                            </td>
                        </tr>

                        <!-- Modal Edit -->
                        <div id="edit<?= $gu['id_guru'] ?>" class="modal" tabindex="-1" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h2 class="font-medium text-base mr-auto">Edit Data Guru</h2>
                                    </div>
                                    <form action="<?= base_url('admin/guru/edit') ?>" method="post">
                                        <div class="modal-body">
                                            <input type="hidden" name="id_guru" value="<?= $gu['id_guru'] ?>">
                                            <div>
                                                <label class="form-label">NIP Guru</label>
                                                <input type="number " class="form-control mb-3" name="nip" 
                                                       value="<?= $gu['nip'] ?>" required>
                                            </div>
                                            <div>
                                                <label class="form-label">Nama Guru</label>
                                                <input type="text" class="form-control mb-3" name="nama_guru" 
                                                       value="<?= $gu['nama_guru'] ?>" required>
                                            </div>
                                            <div>
                                                <label class="form-label">Email</label>
                                                <input type="text" class="form-control mb-3" name="email_guru" 
                                                       value="<?= $gu['email_guru'] ?>" required>
                                            </div>
                                            <div>
                                                <label class="form-label">Password</label>
                                                <input type="text" class="form-control mb-3" name="password" 
                                                       value="<?= $gu['password'] ?>" required>
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

<!-- Modal Add Guru -->
<div id="addGuru" class="modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="font-medium text-base mr-auto">Tambah Data Guru</h2>
      </div>
      <form action="<?= base_url('admin/guru/add') ?>" method="post">
        <div class="modal-body">
            <div>
                <label class="form-label mb-3">NIP Guru</label>
                <input type="text" class="form-control mb-3" name="nip" placeholder="NIP Guru" required>
            </div>
            <div>
            <label class="form-label">Nama Guru</label>
                <input type="text" class="form-control mb-3" name="nama_guru" placeholder="Nama Guru" required>
            </div>
            <div>
                <label class="form-label">Email</label> 
                <input type="email" class="form-control mb-3" name="email_guru" placeholder="Email Guru" required>
            </div>
            <div>
                <label class="form-label">Password</label> 
                <input type="password" class="form-control mb-3" name="password" placeholder="Password Guru" required>
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
        $('#guruTable').DataTable({
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

