<h2 class="intro-y text-lg font-medium">List Data Siswa</h2>

<div class="grid grid-cols-6 mt-5">
	<div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
		<button class="btn btn-primary shadow-md mr-2" data-tw-toggle="modal" data-tw-target="#tambahsiswa">Tambah Data Siswa</button>
		<!-- BEGIN: Modal Add  -->
		<div id="tambahsiswa" class="modal" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h2 class="font-medium text-base mr-auto">Tambah Data Siswa</h2>
					</div> <!-- END: Modal Header -->

					<form action="<?=base_url('admin/siswa/add')?>" method="post">
						<!-- BEGIN: Modal Body -->
						<div class="modal-body ">
							<div class="">
								<label for="modal-form-1" class="form-label">Nisn</label>
								<input id="validation-form-1" type="text" class="form-control" placeholder="Nisn"
									name="nisn" required>
							</div>
							<div class="mt-3">
								<label for="modal-form-2" class="form-label">Nama Siswa</label>
								<input id="modal-form-2" type="text" class="form-control" placeholder="Nama Siswa"
									name="nama" required>
							</div>
							<div class="mt-3">
								<label for="modal-form-3" class="form-label">Tanggal Lahir</label>
								<input type="text" class="datepicker form-control" data-single-mode="true"
									name="tgl_lahir" required>
							</div>
							<div class="mt-3">
								<label for="modal-form-3" class="form-label">Tahun Masuk</label>
								<input type="number" class="form-control" name="thn_masuk" maxlength="4" min="2000"
									max="2025" step="1" placeholder="Tahun Masuk" required>
							</div>

							<div class="mt-3">
								<label for="modal-form-6" class="form-label">Status Siswa</label>
								<select id="modal-form-6" class="form-select" name="status" required>
									<option value="aktif">aktif</option>
									<option value="lulus">lulus</option>
									<option value="keluar">keluar</option>
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
		<!-- END: Modal Add  -->
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
					<th class="table-report__action text-center whitespace-nowrap">NISN</th>
					<th class="table-report__action text-center whitespace-nowrap">NAMA</th>
					<th class="table-report__action text-center whitespace-nowrap">TANGGAL LAHIR</th>
					<th class="table-report__action text-center whitespace-nowrap">TAHUN MASUK</th>
					<th class="table-report__action text-center whitespace-nowrap">STATUS</th>
					<th class="table-report__action text-center whitespace-nowrap">ACTIONS</th>
				</tr>
			</thead>
			<tbody>
				<?php $no=1+ ($offset ?? 0); foreach ($siswa as $sis) {?>
				<tr class="intro-x">
					<td class="w-10"><?= $no ?></td>
					<td class="table-report__action text-center"><?= $sis['nisn'] ?></td>
					<td class="table-report__action text-center"><?= $sis['nama'] ?></td>
					<td class="table-report__action text-center"><?= $sis['tgl_lahir'] ?></td>
					<td class="table-report__action text-center"><?= $sis['thn_masuk'] ?></td>
					<td class="table-report__action text-center"><?= $sis['status'] ?></td>


					<td class="table-report__action w-56">
						<div class="flex justify-center items-center">
							<button class="flex items-center mr-3 text-warning" data-tw-toggle="modal"
								data-tw-target="#edit<?=$sis['id_siswa']?>">
								<i data-lucide="check-square" class="w-4 h-4 mr-1"></i>edit
							</button>
							<!-- BEGIN: Modal Content Edit-->
								<div id="edit<?=$sis['id_siswa']?>" class="modal" tabindex="-1" aria-hidden="true">
									<div class="modal-dialog">
										<div class="modal-content">
											<div class="modal-header">
												<h2 class="font-medium text-base mr-auto">Edit Data Siswa</h2>
											</div> <!-- END: Modal Header -->
											<form action="<?=base_url('admin/siswa/edit')?>" method="post">
												<div class="modal-body ">

													<!-- BEGIN: Modal Body -->
													<input type="hidden" name="id_siswa" value="<?=$sis['id_siswa']?>">
													<div class="">
														<label for="modal-form-8" class="form-label">Nisn</label>
														<input id="validation-form-8" type="text" class="form-control"
															placeholder="Nisn" name="nisn" value="<?= $sis['nisn'] ?>" required>
													</div>
													<div class="">
														<label for="modal-form-9" class="form-label">Nama Siswa</label>
														<input id="validation-form-9" type="text" class="form-control"
															placeholder="Nama Siswa" name="nama" value="<?= $sis['nama'] ?>"
															required>
													</div>
													<?php $tgl_lahir = $sis['tgl_lahir'] ? date('d M, Y', strtotime($sis['tgl_lahir'])) : '';?>
													<div class="mt-3">
														<label for="modal-form-2" class="form-label">Tanggal Lahir</label>
														<input type="text" class="datepicker form-control"
															data-single-mode="true" name="tgl_lahir"
															value="<?= $sis['tgl_lahir'] ?>" required>
													</div>

													<div class="mt-3">
														<label for="modal-form-3" class="form-label">Tahun Masuk</label>
														<input type="number" class="form-control" name="thn_masuk" maxlength="4"
															min="2000" max="2025" step="1" placeholder="Tahun Masuk"
															value="<?= $sis['thn_masuk'] ?>" required>
													</div>

													<div class="mt-3">
														<label for="modal-form-6" class="form-label">Status</label>
														<select id="modal-form-6" class="form-select" name="status">
															<option value="aktif"
																<?=($sis['status']=='aktif')?'selected' : ''?>>aktif</option>
															<option value="lulus"
																<?=($sis['status']=='lulus')?'selected' : ''?>>lulus</option>
															<option value="keluar"
																<?=($sis['status']=='keluar')?'selected' : ''?>>keluar</option>
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
							<!-- END: Modal Content Edit -->
							<a href="javascript:;" data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal"
								data-url="<?= site_url('admin/siswa/delete/'.$sis['id_siswa']) ?>"
								class="flex items-center text-danger">
								<i data-lucide="trash-2" class="w-4 h-4 mr-1"></i>Delete
							</a>
						</div>
						
					</td>
					<!-- BEGIN: Modal Content Edit-->
						<div id="edit<?=$sis['id_siswa']?>" class="modal" tabindex="-1" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h2 class="font-medium text-base mr-auto">Edit Data Siswa</h2>
									</div> <!-- END: Modal Header -->
									<form action="<?=base_url('admin/siswa/edit')?>" method="post">
										<div class="modal-body ">

											<!-- BEGIN: Modal Body -->
											<input type="hidden" name="id_siswa" value="<?=$sis['id_siswa']?>">
											<div class="">
												<label for="modal-form-8" class="form-label">Nisn</label>
												<input id="validation-form-8" type="text" class="form-control"
													placeholder="Nisn" name="nisn" value="<?= $sis['nisn'] ?>" required>
											</div>
											<div class="">
												<label for="modal-form-9" class="form-label">Nama Siswa</label>
												<input id="validation-form-9" type="text" class="form-control"
													placeholder="Nama Siswa" name="nama" value="<?= $sis['nama'] ?>"
													required>
											</div>
											<?php $tgl_lahir = $sis['tgl_lahir'] ? date('d M, Y', strtotime($sis['tgl_lahir'])) : '';?>
											<div class="mt-3">
												<label for="modal-form-2" class="form-label">Tanggal Lahir</label>
												<input type="text" class="datepicker form-control"
													data-single-mode="true" name="tgl_lahir"
													value="<?= $sis['tgl_lahir'] ?>" required>
											</div>

											<div class="mt-3">
												<label for="modal-form-3" class="form-label">Tahun Masuk</label>
												<input type="number" class="form-control" name="thn_masuk" maxlength="4"
													min="2000" max="2025" step="1" placeholder="Tahun Masuk"
													value="<?= $sis['thn_masuk'] ?>" required>
											</div>

											<div class="mt-3">
												<label for="modal-form-6" class="form-label">Status</label>
												<select id="modal-form-6" class="form-select" name="status">
													<option value="aktif"
														<?=($sis['status']=='aktif')?'selected' : ''?>>aktif</option>
													<option value="lulus"
														<?=($sis['status']=='lulus')?'selected' : ''?>>lulus</option>
													<option value="keluar"
														<?=($sis['status']=='keluar')?'selected' : ''?>>keluar</option>
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
					<!-- END: Modal Content Edit -->
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
