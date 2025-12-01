<h2 class="intro-y text-lg font-medium">List Data User</h2>

<!-- Tombol Tambah -->
<div class="text-left mt-5">
    <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#addUser" class="btn btn-primary">
        Tambah User
    </a>
</div>

<!-- Box List User -->
<div class="intro-y box mt-3">
    <div class="p-5">
        <div class="preview">
            <div class="overflow-x-auto">
                <table id="example1" class="table table-auto display datatable w-full">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="border-b-2">NO</th>
                            <th class="border-b-2 w-20">NAMA</th>
                            <th class="border-b-2 w-32">USERNAME</th>
                            <th class="border-b-2 w-24">ROLE</th>
                            <th class="border-b-2 w-30">AKSI</th>

                        </tr>
                    </thead>
                   <tbody>
                        <?php $no=1+ ($offset ?? 0); foreach ($users as $ok) { ?>
                        <tr>
                            <td class=""><?= $no ?></td>
                            <td class=""><?= $ok['nama'] ?></td>
                            <td class=""><?= $ok['username'] ?></td>
                            <td class=""><?= $ok['role'] ?></td>
                            <td class="">
                                <div class="flex space-x-10">
                                    <!-- Edit -->
                                    <a class="flex text-blue-500 mr-5" href="javascript:;" 
                                      data-tw-toggle="modal" data-tw-target="#edit<?= $ok['id_user'] ?>">
                                        <i data-lucide="edit" class="w-4 h-4 mr-1"></i> Edit
                                    </a>

                                    <!-- Delete -->
                                    <a class="flex text-danger delete-btn" href="javascript:;" 
                                      onclick="confirmDelete('<?= site_url('user/delete/'.$ok['id_user']) ?>')">
                                        <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete
                                    </a>
                                </div>
                            </td>
                        </tr>
                        <?php $no++; } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Add User -->
<div id="addUser" class="modal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h2 class="font-medium text-base mr-auto">Tambah User</h2>
      </div>
      <form action="<?= base_url('user/add') ?>" method="post">
        <div class="modal-body">
          <div>
            <label class="form-label">Nama</label>
            <input type="text" class="form-control" placeholder="Nama" name="nama" required>
          </div>
          <div class="mt-3">
            <label class="form-label">Username</label>
            <input type="text" class="form-control" placeholder="Username" name="username" required>
          </div>
          <div class="mt-3">
            <label class="form-label">Password</label>
            <input type="password" class="form-control" placeholder="Create Password" name="password" required>
          </div>
          <div class="mt-3">
            <label class="form-label">Role</label>
            <select class="form-select" name="role" required>
              <option value="admin">Admin</option>
              <option value="kepala sekolah">Kepala Sekolah</option>
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

<?php foreach ($users as $ok) { ?>
<div id="edit<?= $ok['id_user'] ?>" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h2 class="font-medium text-base mr-auto">Edit User</h2>
            </div>
            <form action="<?= base_url('user/edit') ?>" method="post">
                <div class="modal-body">
                    <input type="hidden" name="id_user" value="<?= $ok['id_user'] ?>">
                    <div>
                        <label class="form-label">Nama</label>
                        <input type="text" class="form-control" name="nama" 
                               value="<?= $ok['nama'] ?>" required>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" name="username" 
                               value="<?= $ok['username'] ?>" required>
                    </div>
                    <div class="mt-3">
                        <label class="form-label">Role</label>
                        <select class="form-select" name="role">
                            <option value="admin" <?=($ok['role']=='admin')?'selected':''?>>Admin</option>
                            <option value="kepala sekolah" <?=($ok['role']=='kepala sekolah')?'selected':''?>>Kepala Sekolah</option>
                            <option value="guru" <?=($ok['role']=='guru')?'selected':''?>>Guru</option>
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
<?php } ?>
