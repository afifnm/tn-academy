<h2 class="intro-y text-lg font-medium">List Data Enroll</h2>


<div class="grid grid-cols-6 mt-5">
	<div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
		<a class="btn btn-primary shadow-md mr-2" href="<?=base_url('admin/enroll/add')?>">Enroll Data Siswa</a>
		<!-- BEGIN: Modal Add User -->
		
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
					<th class="table-report__action text-center whitespace-nowrap">NAMA SISWA</th>
                    <th class="table-report__action text-center whitespace-nowrap">KELAS</th>
                    <th class="table-report__action text-center whitespace-nowrap">TAHUN AJARAN</th>
                    <th class="table-report__action text-center whitespace-nowrap">SEMESTER</th>
                    <th class="table-report__action text-center whitespace-nowrap">STATUS</th>
                    <th class="table-report__action text-center whitespace-nowrap">TANGGAL ENROLL</th>
					<th class="table-report__action text-center whitespace-nowrap">ACTIONS</th>
				</tr>
			</thead>
			<tbody>
				<?php $no=1+ ($offset ?? 0); foreach ($enroll as $enr) {?>
				<tr class="intro-x">
					<td class="w-10"><?= $no ?></td>
					<td class="table-report__action text-center"><?= $enr['nama'] ?></td>
                    <td class="table-report__action text-center"><?= $enr['nama_kelas'] ?></td>
                    <td class="table-report__action text-center"><?= $enr['tahun'] ?></td>
                    <td class="table-report__action text-center"><?= $enr['semester'] ?></td>
                    <td class="table-report__action text-center"><?= $enr['status'] ?></td>
                    <td class="table-report__action text-center"><?= $enr['tanggal_enroll'] ?></td>


					<td class="table-report__action w-60">
						<div class="flex justify-center items-center">
							<button class="flex items-center mr-3 text-warning" data-tw-toggle="modal"
								data-tw-target="#edit<?=$enr['id_enroll']?>">
								<i data-lucide="check-square" class="w-4 h-4 mr-1"></i>edit
							</button>
                            	
							
                            <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal" 
                                data-url="<?= site_url('admin/enroll/delete/'.$enr['id_enroll']) ?>" 
                                class="flex items-center text-danger">
                                <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i>Delete
                            </a>


						</div>
					</td>
                    <!-- BEGIN: Modal Content -->
                    <div id="edit<?=$enr['id_enroll']?>" class="modal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2 class="font-medium text-base mr-auto">Edit Data Enroll</h2>
                                </div> <!-- END: Modal Header -->
                                 <form action="<?=base_url('admin/enroll/update')?>" method="post">
                                    <div class="modal-body ">
                                        <input type="hidden" name="id_enroll" value="<?=$enr['id_enroll']?>">
                                        <div class="mt-3">
                                            <label>Nama Siswa</label>
                                            <div class="mt-2"> <select data-placeholder="Cari Nama siswa" class="tom-select w-full" name="id_siswa" class="form-control" required>
                                                <option value="">-- Pilih Siswa --</option>
                                                <?php foreach ($siswa as $s): ?> 
                                                    <option value="<?= $s->id_siswa ?>" <?= ($enr['id_siswa'] == $s->id_siswa) ? 'selected' : '' ?>>
                                                         <?= $s->nama ?>
                                                    </option> 
                                                <?php endforeach; ?>
                                                </select> 
                                            </div>
                                        </div>

                                        <div class="mt-3">
                                            <label class="form-label">Kelas</label>
                                            <select name="id_kelas" class="form-control" required>
                                                <option value="">-- Pilih Kelas --</option>
                                                <?php foreach ($kelas as $k): ?>
                                                    <option value="<?= $k->id_kelas ?>" 
                                                        <?= ($enr['id_kelas'] == $k->id_kelas) ? 'selected' : '' ?>>
                                                        <?= $k->nama_kelas ?>
                                                    </option>
                                                <?php endforeach; ?>

                                            </select>
                                        </div>

                                        <div class="mt-3">
                                            <label class="form-label">Tahun Ajaran</label>
                                            <select name="id_ta" class="form-control" required>
                                                <option value="">-- Pilih Tahun Ajaran --</option>
                                                <?php foreach ($tahun_ajaran as $ta): ?>
                                                    <option value="<?= $ta->id_ta ?>" 
                                                        <?= ($enr['id_ta'] == $ta->id_ta) ? 'selected' : '' ?>>
                                                        <?= $ta->tahun ?> (<?= $ta->semester ?>)
                                                    </option>
                                                <?php endforeach; ?>

                                            </select>
                                        </div>

                                        <div class="mt-3">
                                            <label class="form-label">Status</label>
                                            <select name="status" class="form-control" required>
                                                <option value="aktif"    <?= ($enr['status'] == 'aktif') ? 'selected' : '' ?>>Aktif</option>
                                                <option value="nonaktif" <?= ($enr['status'] == 'nonaktif') ? 'selected' : '' ?>>Nonaktif</option>
                                                <option value="pindah"   <?= ($enr['status'] == 'pindah') ? 'selected' : '' ?>>Pindah</option>
                                                <option value="lulus"    <?= ($enr['status'] == 'lulus') ? 'selected' : '' ?>>Lulus</option>
                                            </select>

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
