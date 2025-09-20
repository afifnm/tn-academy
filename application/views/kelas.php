<h2 class="intro-y text-lg font-medium">List Data Kelas</h2>


<div class="grid grid-cols-6 mt-5">
	<div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
		<button class="btn btn-primary shadow-md mr-2" data-tw-toggle="modal" data-tw-target="#tambahKelas">Tambah Data Kelas</button>
		<!-- BEGIN: Modal Add User -->
		<div id="tambahKelas" class="modal" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h2 class="font-medium text-base mr-auto">Tambah Data Kelas</h2>
					</div> <!-- END: Modal Header -->

					<form action="<?=base_url('admin/kelas/add')?>" method="post">
						<!-- BEGIN: Modal Body -->
						<div class="modal-body ">
							<div class="">
								<label for="modal-form-1" class="form-label">Nama Kelas</label>
								<input id="validation-form-1" type="text" class="form-control" placeholder="Nama Kelas"
									name="nama_kelas" required>
							</div>

                            <div class="mt-3">
								<label for="modal-form-6" class="form-label">Tingkat</label>
								<select id="modal-form-6" class="form-select" name="tingkat" required>
									<option value="X">X</option>
									<option value="XI">XI</option>
									<option value="XII">XII</option>
								</select>
							</div>

                            <div class="mt-3">
								<label for="modal-form-1" class="form-label">Jurusan</label>
								<input id="validation-form-1" type="text" class="form-control" placeholder="Jurusan"
									name="jurusan" required>
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
		<!-- <div class="hidden md:block mx-auto text-slate-500">Showing 1 to 10 of 150 entries</div> -->
		<div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-2">
			<div class="w-56 relative text-slate-500">
				<input type="text" class="form-control w-56 box pr-10" placeholder="Search...">
				<i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
			</div>
		</div>
	</div>
	<!-- BEGIN: Data List -->
	<div class="intro-y col-span-12 overflow-auto lg:overflow-visible">
		<table class="table table-report -mt-2" id="myTable">
			<thead>
				<tr>
					<th class="table-report__action whitespace-nowrap">NO</th>
					<th class="table-report__action text-center whitespace-nowrap">NAMA KELAS</th>
                    <th class="table-report__action text-center whitespace-nowrap">TINGKAT</th>
                    <th class="table-report__action text-center whitespace-nowrap">JURUSAN</th>
					<th class="table-report__action text-center whitespace-nowrap">ACTIONS</th>
				</tr>
			</thead>
			<tbody>
				<?php $no=1+ ($offset ?? 0); foreach ($kelas as $kel) {?>
				<tr class="intro-x">
					<td class="w-10"><?= $no ?></td>
					<td class="table-report__action text-center"><?= $kel['nama_kelas'] ?></td>
                    <td class="table-report__action text-center"><?= $kel['tingkat'] ?></td>
                    <td class="table-report__action text-center"><?= $kel['jurusan'] ?></td>


					<td class="table-report__action w-60">
						<div class="flex justify-center items-center">
							<button class="flex items-center mr-3 text-warning" data-tw-toggle="modal"
								data-tw-target="#edit<?=$kel['id_kelas']?>">
								<i data-lucide="check-square" class="w-4 h-4 mr-1"></i>edit
							</button>
                            	
							
                            <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal" 
                                data-url="<?= site_url('admin/kelas/delete/'.$kel['id_kelas']) ?>" 
                                class="flex items-center text-danger">
                                <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i>Delete
                            </a>


						</div>
					</td>
                    <!-- BEGIN: Modal Content -->
                    <div id="edit<?=$kel['id_kelas']?>" class="modal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2 class="font-medium text-base mr-auto">Edit Data Kelas</h2>
                                </div> <!-- END: Modal Header -->
                                <form action="<?=base_url('admin/kelas/edit')?>" method="post">
                                    <div class="modal-body ">

                                        <!-- BEGIN: Modal Body -->
                                        <input type="hidden" name="id_kelas" value="<?=$kel['id_kelas']?>">
                                        <div class="">
                                            <label for="modal-form-7" class="form-label">Nama Kelas</label>
                                            <input id="validation-form-8" type="text" class="form-control" placeholder="Nama Kelas"
                                                name="nama_kelas" value="<?= $kel['nama_kelas'] ?>" required>
                                        </div>
                                        <div class="mt-3">
                                            <label for="modal-form-6" class="form-label">Tingkat</label>
                                            <select id="modal-form-6" class="form-select" name="tingkat" required>
                                                <option value="X" <?=($kel['tingkat']=='X')?'selected' : ''?>>X</option>
                                                <option value="XI" <?=($kel['tingkat']=='XI')?'selected' : ''?>>XI</option>
                                                <option value="XII" <?=($kel['tingkat']=='XII')?'selected' : ''?>>XII</option>
                                            </select>
                                        </div>
                                        <div class="mt-3">
                                            <label for="modal-form-11" class="form-label">Jurusan</label>
                                            <input id="validation-form-12" type="text" class="form-control" placeholder="Jurusan"
                                                name="jurusan" value="<?= $kel['jurusan'] ?>" required>
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
				</tr>
				<?php $no++; }?>
			</tbody>
			<!-- BEGIN: Modal Toggle -->
		</table>
        
	</div>
	<!-- END: Data List -->




	<!-- BEGIN: Pagination -->
	<?php $this->load->view('components/pagination', ['pagination' => $pagination]); ?>
	<!-- END: Pagination -->

</div>
