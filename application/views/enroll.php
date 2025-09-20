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
                    
				</tr>
				<?php $no++; }?>
			</tbody>
		</table>
        
	</div>
	<!-- END: Data List -->




	<!-- BEGIN: Pagination -->
	<?php $this->load->view('components/pagination', ['pagination' => $pagination]); ?>
	<!-- END: Pagination -->

</div>
