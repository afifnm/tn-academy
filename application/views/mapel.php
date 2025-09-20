<h2 class="intro-y text-lg font-medium">List Mata Pelajaran</h2>


<div class="grid grid-cols-6 mt-5">
	<div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
		<button class="btn btn-primary shadow-md mr-2" data-tw-toggle="modal" data-tw-target="#tambahMapel">Tambah Mata Pelajaran</button>
		<!-- BEGIN: Modal Add User -->
		<div id="tambahMapel" class="modal" tabindex="-1" aria-hidden="true">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<h2 class="font-medium text-base mr-auto">Tambah Mata Pelajaran</h2>
					</div> <!-- END: Modal Header -->

					<form action="<?=base_url('admin/mapel/add')?>" method="post">
						<!-- BEGIN: Modal Body -->
						<div class="modal-body ">
							<div class="">
								<label for="modal-form-1" class="form-label">Nama Mata Pelajaran</label>
								<input id="validation-form-1" type="text" class="form-control" placeholder="Nama Mapel"
									name="nama_mapel" required>
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
					<th class="table-report__action text-center whitespace-nowrap">MATA PELAJARAN</th>
					<th class="table-report__action text-center whitespace-nowrap">ACTIONS</th>
				</tr>
			</thead>
			<tbody>
				<?php $no=1+ ($offset ?? 0); foreach ($mapel as $ma) {?>
				<tr class="intro-x">
					<td class="w-10"><?= $no ?></td>
					<td class="table-report__action text-center"><?= $ma['nama_mapel'] ?></td>
					<td class="table-report__action w-60">
						<div class="flex justify-center items-center">
							<button class="flex items-center mr-3 text-warning" data-tw-toggle="modal"
								data-tw-target="#edit<?=$ma['id_mapel']?>">
								<i data-lucide="check-square" class="w-4 h-4 mr-1"></i>edit
							</button>
                            	
							
                            <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal" 
                                data-url="<?= site_url('admin/mapel/delete/'.$ma['id_mapel']) ?>" 
                                class="flex items-center text-danger">
                                <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i>Delete
                            </a>


						</div>
					</td>
                    <!-- BEGIN: Modal Content -->
                    <div id="edit<?=$ma['id_mapel']?>" class="modal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h2 class="font-medium text-base mr-auto">Edit Mata Pelajaran</h2>
                                </div> <!-- END: Modal Header -->
                                <form action="<?=base_url('admin/mapel/edit')?>" method="post">
                                    <div class="modal-body ">

                                        <!-- BEGIN: Modal Body -->
                                        <input type="hidden" name="id_mapel" value="<?=$ma['id_mapel']?>">
                                        <div class="">
                                            <label for="modal-form-1" class="form-label">Nama Mata Pelajaran</label>
                                            <input id="validation-form-1" type="text" class="form-control" placeholder="Nama Mata Pelajaran"
                                                name="nama_mapel" value="<?= $ma['nama_mapel'] ?>" required>
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
