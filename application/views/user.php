<h2 class="intro-y text-lg font-medium">List Data User</h2>


<div class="grid grid-cols-6 mt-5">
	<div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
		<button class="btn btn-primary shadow-md mr-2" data-tw-toggle="modal" data-tw-target="#addUser">Tambah
			User</button>
		<!-- BEGIN: Modal Add User -->
		<div id="addUser" class="modal" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h2 class="font-medium text-base mr-auto">Tambah User</h2>
					</div> <!-- END: Modal Header -->

					<form action="<?=base_url('user/add')?>" method="post">
						<!-- BEGIN: Modal Body -->
						<div class="modal-body ">
							<div class="">
								<label for="modal-form-1" class="form-label">Name</label>
								<input id="validation-form-1" type="text" class="form-control" placeholder="Name"
									name="name" required>
							</div>
							<div class="mt-3">
								<label for="modal-form-2" class="form-label">Username</label>
								<input id="modal-form-2" type="text" class="form-control" placeholder="Username"
									name="username" required>
							</div>
							<div class="mt-3">
								<label for="modal-form-3" class="form-label">Password</label>
								<input id="modal-form-3" type="password" class="form-control"
									placeholder="Create Password" name="password" required>
							</div>

							<div class="mt-3">
								<label for="modal-form-6" class="form-label">Role</label>
								<select id="modal-form-6" class="form-select" name="role" required>
									<option value="admin">admin</option>
									<option value="kepala sekolah">kepala sekolah</option>
									<option value="guru">guru</option>
								</select>
							</div>
						</div>
						<!-- END: Modal Body -->
						<!-- BEGIN: Modal Footer -->
						<div class="modal-footer">
							<button type="button" data-tw-dismiss="modal"
								class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
							<button type="submit" class="btn btn-primary w-20">Save</button>
						</div> <!-- END: Modal Footer -->
					</form>

				</div>
			</div>
		</div>
		<!-- END: Modal Add User -->
	</div>
	<!-- BEGIN: Data List -->
	<div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
		<table class="table table-report -mt-2" id="example1">
			<thead>
				<tr>
					<th class="table-report__action whitespace-nowrap">NO</th>
					<th class="table-report__action text-center whitespace-nowrap">NAMA</th>
					<th class="table-report__action text-center whitespace-nowrap">USERNAME</th>
					<th class="table-report__action text-center whitespace-nowrap">ROLE</th>
					<th class="table-report__action text-center whitespace-nowrap">ACTIONS</th>
				</tr>
			</thead>
			<tbody>
				<?php $no=1+ ($offset ?? 0); foreach ($users as $ok) {?>
				<tr class="intro-x">
					<td class="w-10"><?= $no ?></td>
					<td class="table-report__action text-center"><?= $ok['nama'] ?></td>
					<td class="table-report__action text-center"><?= $ok['username'] ?></td>

					<td class="table-report__action w-50">
						<div class="flex items-center justify-center"><?= $ok['role'] ?></div>
					</td>
					<td class="table-report__action w-56">
						<div class="flex justify-center items-center">
							<button class="flex items-center mr-3 text-warning" data-tw-toggle="modal"
								data-tw-target="#edit<?=$ok['id_user']?>">
								<i data-lucide="check-square" class="w-4 h-4 mr-1"></i>edit
							</button>
                            	<!-- BEGIN: Modal Content -->
                            <div id="edit<?=$ok['id_user']?>" class="modal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h2 class="font-medium text-base mr-auto">Edit User</h2>
                                        </div> <!-- END: Modal Header -->
                                        <form action="<?=base_url('user/edit')?>" method="post">
                                            <div class="modal-body ">

                                                <!-- BEGIN: Modal Body -->
                                                <input type="hidden" name="id_user" value="<?=$ok['id_user']?>">
                                                <div class="">
                                                    <label for="modal-form-1" class="form-label">Name</label>
                                                    <input id="validation-form-1" type="text" class="form-control" placeholder="Name"
                                                        name="name" value="<?= $ok['name'] ?>" required>
                                                </div>
                                                <div class="mt-3">
                                                    <label for="modal-form-2" class="form-label">Username</label>
                                                    <input id="modal-form-2" type="text" class="form-control" placeholder="Username"
                                                        name="username" value="<?= $ok['username'] ?>" required>
                                                </div>

                                                <div class="mt-3">
                                                    <label for="modal-form-6" class="form-label">Role</label>
                                                    <select id="modal-form-6" class="form-select" name="role">
                                                        <option value="admin" <?=($ok['role']=='admin')?'selected' : ''?>>admin</option>
                                                        <option value="kepala sekolah" <?=($ok['role']=='kepala sekolah')?'selected' : ''?>>
                                                            kepala sekolah</option>
                                                        <option value="guru" <?=($ok['role']=='guru')?'selected' : ''?>>guru</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- END: Modal Body -->
                                            <!-- BEGIN: Modal Footer -->
                                            <div class="modal-footer">
                                                <button type="button" data-tw-dismiss="modal"
                                                    class="btn btn-outline-secondary w-20 mr-1">Cancel</button>
                                                <button type="submit" class="btn btn-primary w-20">Save</button>
                                            </div> <!-- END: Modal Footer -->
                                        </form>


                                    </div>
                                </div>

                            </div>
                            <!-- END: Modal Content -->
							
                            <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal" 
                                data-url="<?= site_url('user/delete/'.$ok['id_user']) ?>" 
                                class="flex items-center text-danger">
                                <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i>Delete
                            </a>


						</div>
					</td>
				</tr>
				<?php $no++; }?>
			</tbody>
			<!-- BEGIN: Modal Toggle -->
		</table>
	</div>
	<!-- END: Data List -->
</div>
