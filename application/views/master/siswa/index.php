<style>/* Reset style bawaan Dropzone agar tidak bentrok */
.dropzone {
  border: 2px dashed #3b82f6;
  border-radius: 12px;
  background-color: #f1f8ff;
  padding: 30px;
  transition: 0.3s ease;
  text-align: center;
  min-height: 180px;
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-items: center;
}

.dropzone .dz-message {
  display: flex;
  flex-direction: column;
  align-items: center;
  color: #6b7280;
  font-size: 0.95rem;
  font-weight: 500;
}

.dropzone.dz-started .dz-message {
  display: none;
}

.dropzone .dz-preview {
  display: inline-flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  position: relative;
  margin: 5px auto;
}

.dropzone .dz-image {
  background: #f9fafb;
  border-radius: 16px;
  width: 110px;
  height: 110px;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 14px;
  color: #374151;
  box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
  position: relative;
  z-index: 1; 
}

.dropzone .dz-filename span {
  font-size: 0.8rem;
  font-weight: 500;
  color: #374151;
  margin-top: 6px;
  display: block;
  max-width: 100px;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.dropzone .dz-size span {
  font-size: 0.75rem;
  color: #6b7280;
  font-weight: 600;
}
.dropzone .dz-remove {
  position: absolute;
  top: -6px;
  right: -6px;
  background: #ef4444;
  color: white !important;
  border-radius: 50%;
  width: 20px;
  height: 20px;
  font-size: 0; 
  line-height: 20px;
  text-align: center;
  cursor: pointer;
  text-decoration: none;
  opacity: 0.9;
  transition: 0.2s ease;
    z-index: 10;
}

.dropzone .dz-remove:hover {
  opacity: 1;
  background: #dc2626;
}

.dropzone .dz-remove::before {
  content: "×";
  font-size: 14px;
  font-weight: bold;
  display: inline-block;
  line-height: 20px;
  z-index: 20;
}

.dropzone .dz-progress {
  display: none !important;
}






</style>

<!-- Tombol Tambah -->
<div class="flex items-center justify-between mb-4">
	<div class="flex items-center gap-2">
		<!-- Tombol Tambah Data Siswa -->
		<a href="<?=base_url('admin/siswa/add')?>" class="btn btn-primary">
			Tambah Data Siswa
		</a>

		<!-- Tombol Import Excel -->
		<a href="javascript:;" data-tw-toggle="modal" data-tw-target="#importExcel" class="btn btn-success">
			Import Excel
		</a>
	</div>

</div>

<!-- Box List Siswa -->
<div class="intro-y box mt-4">
	<div class="p-5">
		<div class="preview">
			<div class="overflow-x-auto">
				<!-- Filter Tahun Masuk -->
				<div class="mb-4">
					<form action="<?= base_url('admin/siswa') ?>" method="get" class=" gap-3">
						<label for="thn_masuk" class="font-medium text-gray-700">Filter Tahun Masuk:</label>
						<select name="thn_masuk" id="thn_masuk" class="form-select w-44" onchange="this.form.submit()">
							<option value="">Pilih Tahun Masuk</option>
							<?php foreach ($daftar_thn as $t): ?>
							<option value="<?= $t['thn_masuk'] ?>"
								<?= ($t['thn_masuk'] == $thn_masuk) ? 'selected' : '' ?>>
								<?= $t['thn_masuk'] ?>
							</option>
							<?php endforeach; ?>
						</select>
						<?php if ($thn_masuk): ?>
						<a href="<?= base_url('admin/siswa') ?>" class="btn btn-outline-secondary ml-2">Reset</a>
						<?php endif; ?>
					</form>
				</div>

				<table id="example1" class="table table-report table-report--bordered display datatable w-full">
					<thead class="bg-gray-100">
						<tr>
							<th>NO</th>
							<th>NISN</th>
							<th>NIS</th>
							<th>NAMA</th>
							<th>JALUR PENDIDIKAN</th>
							<th>TAHUN MASUK</th>
							<th>STATUS</th>
							<th>AKSI</th>
						</tr>
					</thead>
					<tbody>
						<?php if (empty($siswa)): ?>
						<tr>
							<td colspan="8" class="text-center text-slate-500 py-4">
								Pilih tahun masuk untuk menampilkan data.
							</td>
						</tr>
						<?php else: ?>
						<?php $no=1+ ($offset ?? 0); foreach ($siswa as $sis) { ?>
						<tr>
							<td><?= $no ?></td>
							<td><?= $sis['nisn'] ?></td>
							<td><?= $sis['nis'] ?></td>
							<td><?= $sis['nama'] ?></td>
							<td><?= $sis['jalur_pendidikan'] ?></td>
							<td><?= $sis['thn_masuk'] ?></td>
							<td><?= $sis['status'] ?></td>
							<td>
								<div class="flex space-x-15">
									<!-- Detail -->
									<a class="flex text-blue-500 mr-4"
										href="<?= base_url('admin/siswa/detail/'.$sis['id_siswa']) ?>">
										<i data-lucide="external-link" class="w-4 h-4 mr-1"></i> Detail
									</a>

									<!-- Edit
                                        <a class="flex text-blue-500 mr-4" href="javascript:      ;" 
                                        data-tw-toggle="modal" data-tw-target="#edit<?= $sis['id_siswa'] ?>">
                                            <i data-lucide="edit" class="w-4 h-4 mr-1"></i> Edit
                                        </a> -->

									<!-- Delete -->
									<a class="flex text-danger delete-btn" href="javascript:;"
										onclick="confirmDelete('<?= site_url('admin/siswa/delete/'.$sis['id_siswa']) ?>')">
										<i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete
									</a>
								</div>
							</td>
						</tr>
						<!-- Modal Edit -->
						<div id="edit<?= $sis['id_siswa'] ?>" class="modal" tabindex="-1" aria-hidden="true">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h2 class="font-medium text-base mr-auto">Edit Data Siswa</h2>
									</div>
									<form action="<?= base_url('admin/siswa/edit') ?>" method="post">
										<div class="modal-body">
											<input type="hidden" name="id_siswa" value="<?= $sis['id_siswa'] ?>">

											<div>
												<label class="form-label">NISN</label>
												<input type="text" class="form-control" name="nisn"
													value="<?= $sis['nisn'] ?>" required>
											</div>
											<div class="mt-3">
												<label class="form-label">Nama Siswa</label>
												<input type="text" class="form-control" name="nama"
													value="<?= $sis['nama'] ?>" required>
											</div>
											<div class="mt-3">
												<label class="form-label">Tanggal Lahir</label>
												<input type="text" class="datepicker form-control"
													data-single-mode="true" name="tgl_lahir"
													value="<?= $sis['tgl_lahir'] ?>" required>
											</div>
											<div class="mt-3">
												<label class="form-label">Tahun Masuk</label>
												<input type="number" class="form-control" name="thn_masuk"
													value="<?= $sis['thn_masuk'] ?>" required>
											</div>
											<div class="mt-3">
												<label class="form-label">Status</label>
												<select class="form-select" name="status" required>
													<option value="aktif" <?=($sis['status']=='aktif')?'selected':''?>>
														Aktif</option>
													<option value="lulus" <?=($sis['status']=='lulus')?'selected':''?>>
														Lulus</option>
													<option value="keluar"
														<?=($sis['status']=='keluar')?'selected':''?>>Keluar</option>
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
						<!-- End Modal Edit -->

						<?php $no++; } ?>
						<?php endif; ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>


<!-- BEGIN: Modal Import Excel -->
<div id="importExcel" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
        <!-- Header -->
        <div class="modal-header">
            <h2 class="font-medium text-base mr-auto">Import Data Siswa dari Excel</h2>
            <button type="button" class="btn-close" data-tw-dismiss="modal" aria-label="Close">
            <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        <div class="intro-y box p-5">
            <div class="col-span-12">
                    <div class="alert alert-warning flex items-center mb-4">
                        <i data-lucide="info" class="w-5 h-5 mr-2"></i>
                        Format harus sesuai template.
                        <a href="<?=base_url('admin/siswa/download_template')?>" class="underline ml-1" download>
                        Unduh Template
                        </a>
                    </div>
                </div>
            
                <!-- HANYA form dengan class dropzone, TANPA input asli -->
                <form 
                id="importExcelForm" 
                action="<?= base_url('admin/siswa/importExcel') ?>" 
                method="post" 
                enctype="multipart/form-data"
                class="dropzone" data-single="true"
                >
                <div class="">
                    <!-- Info & Download Template -->

                    <!-- Dropzone Area -->
                    <div class="col-span-12">
                        <!-- TIDAK ADA <input> di sini -->
                        <div class="dz-message">
                            <div class="text-lg font-medium">Drop file Excel di sini atau klik untuk upload.</div>
                            <div class="text-slate-500 mt-1">
                            Format: <span class="font-medium">.xlsx</span> atau <span class="font-medium">.xls</span> •
                            </div>
                        </div>
                    </div>
                </div>

                
                </form>
                <div class="modal-footer py-0 mt-4">
                    <button type="button" data-tw-dismiss="modal" class="btn btn-outline-secondary w-20 mr-1">Batal</button>
                    <button type="submit" id="btnImport" class="btn btn-success w-24">Impor</button>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- END: Modal Import Excel -->


<script>
    document.addEventListener("DOMContentLoaded", function() {

    // Pastikan auto discover dimatikan SEBELUM apapun
    Dropzone.autoDiscover = false;

    // Cegah inisialisasi ganda
    if (Dropzone.instances.length > 0) {
        Dropzone.instances.forEach(dz => dz.destroy());
        console.log("Dropzone lama dihancurkan sebelum inisialisasi ulang");
    }

    // Pastikan form belum memiliki Dropzone sebelumnya
    const formElement = document.querySelector("#importExcelForm");
    if (formElement.dropzone) {
        console.log("Dropzone sudah ada di form, skip inisialisasi.");
        return;
    }

    // Inisialisasi Dropzone baru
    const myDropzone = new Dropzone(formElement, {
        url: "<?= base_url('admin/siswa/importExcel') ?>",
        paramName: "file_excel",
        maxFilesize: 10, // MB
        acceptedFiles: ".xlsx,.xls",
        addRemoveLinks: true,
        dictDefaultMessage: "Drop file Excel di sini atau klik untuk upload.",
        dictRemoveFile: "",
        autoProcessQueue: false,
        uploadMultiple: false,
        parallelUploads: 1,
        maxFiles: 1,
        headers: {
        '<?= $this->security->get_csrf_token_name() ?>': '<?= $this->security->get_csrf_hash() ?>'
        },

        init: function() {
        const dz = this;

        dz.on("addedfile", function(file) {
            if (dz.files.length > 1) {
            dz.removeFile(dz.files[0]);
            }
        });

        dz.on("removedfile", function(file) {
        });

        dz.on("queuecomplete", function() {
            dz.removeAllFiles(true);
        });

        dz.on("success", function(file, response) {
            // Tutup modal setelah upload sukses
            const modalEl = document.querySelector("#importExcel");
            const modalInstance = tailwind.Modal.getInstance(modalEl);

            if (modalInstance) {
                modalInstance.hide();
            } else {
                modalEl.setAttribute("aria-hidden", "true");
                modalEl.classList.remove("show");
            }

            // Bersihkan file dari dropzone
            dz.removeAllFiles(true);

            // Opsional: reload halaman setelah 1 detik biar data siswa muncul
            setTimeout(() => location.reload(), 1000);
        });
        }
    });

    // Tombol Impor
    document.getElementById('btnImport').addEventListener('click', function() {
        if (myDropzone.getAcceptedFiles().length > 0) {
        myDropzone.processQueue();
        } else {
        alert('Silakan pilih file terlebih dahulu.');
        }
    });

    // Tombol Batal & Close (hapus file)
    document.querySelectorAll('#importExcel [data-tw-dismiss="modal"]').forEach(btn => {
        btn.addEventListener('click', function() {
        myDropzone.removeAllFiles(true);
        console.log("Modal ditutup, file dihapus");
        });
    });

    // Observer: jika modal disembunyikan (aria-hidden)
    const modal = document.getElementById('importExcel');
    const observer = new MutationObserver(function(mutations) {
        mutations.forEach(mutation => {
        if (mutation.attributeName === "aria-hidden" && modal.getAttribute("aria-hidden") === "true") {
            myDropzone.removeAllFiles(true);
            console.log("Modal disembunyikan, file dihapus otomatis.");
        }
        });
    });
    observer.observe(modal, { attributes: true });
    });
</script>

