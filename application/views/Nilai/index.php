<div class="p-4">
    <?php if($this->session->flashdata('error')): ?>
        <div class="alert alert-danger mb-4"><?= $this->session->flashdata('error') ?></div>
    <?php endif; ?>
    <?php if($this->session->userdata('role')=='admin'): ?>
    <form method="GET" class="intro-y col-span-12 flex flex-wrap xl:flex-nowrap items-center mt-2 mb-5">
        <div class="flex w-full sm:w-auto">
            <div class="w-30 relative text-slate-500">
                <select name="id_kelas" class="form-select box w-30" required>
                    <option value="">-- Pilih Kelas --</option>
                    <?php foreach($kelas as $k): ?>
                        <option value="<?= $k['id_kelas'] ?>" <?= isset($id_kelas) && $id_kelas==$k['id_kelas'] ? 'selected':'' ?>>
                            <?= htmlspecialchars($k['nama_kelas']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="w-30 relative text-slate-500 ml-2">
                <select name="id_ta" class="form-select box w-30" required>
                    <option value="">-- Pilih Tahun Ajaran --</option>
                    <?php foreach($tahun_ajaran as $ta): ?>
                        <option value="<?= $ta->id_ta ?>" <?= isset($id_ta) && $id_ta==$ta->id_ta ? 'selected':'' ?>>
                            <?= htmlspecialchars($ta->tahun . ' - ' . $ta->semester) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary shadow-md ml-2 mr-2">Tampilkan Mapel</button>
            <?php if (isset($id_kelas) && isset($id_ta)): ?>
            <form method="GET" class="intro-y col-span-12 flex flex-wrap xl:flex-nowrap items-center mt-2 mb-5">
                <div class="flex w-full sm:w-auto">
                    <div class="w-30 relative text-slate-500">
                        <select name="id_mapel" class="form-select box w-30" required>
                            <option value="">-- Pilih Mapel --</option>
                            <?php if (!empty($mapel_list)): ?>
                                <?php foreach($mapel_list as $m): ?>
                                    <option value="<?= $m['id_mapel'] ?>" <?= isset($id_mapel) && $id_mapel==$m['id_mapel'] ? 'selected':'' ?>>
                                        <?= htmlspecialchars($m['nama_mapel']) ?>
                                    </option>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <option disabled>Tidak ada mapel tersedia</option>
                            <?php endif; ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary shadow-md ml-2">Tampilkan Input Nilai</button>
                </div>
            </form>
            <?php endif; ?>
        </div>
    </form>
    <?php endif; ?>
    <?php if (isset($id_kelas) && isset($id_ta) && isset($id_mapel)): ?>
        <div class="intro-y box p-5 w-full overflow-auto bg-white rounded-lg shadow-sm">
            <div class="flex items-center gap-2 justify-end">
                <!-- Tombol Import Excel -->
                <a href="javascript:;" data-tw-toggle="modal" data-tw-target="#importExcel" class="btn btn-success">
                    Import Excel
                </a>
            </div>
            <h3 class="font-medium text-lg mb-4">Mata Pelajaran <?= htmlspecialchars($mapel_terpilih->nama_mapel ?? '—') ?></h3>
            <?php if(!empty($siswa) && !empty($mapel_terpilih)): ?>
                <?php if (!empty($mapel_terpilih->komponen)): ?>
                    <form action="<?= base_url('nilai/save') ?>" method="POST">
                        <input type="hidden" name="id_kelas" value="<?= $id_kelas ?>">
                        <input type="hidden" name="id_ta" value="<?= $id_ta ?>">
                        <input type="hidden" name="id_mapel" value="<?= $id_mapel ?>">

                        <div class="overflow-x-auto">
                            <table class="table table-striped w-full text-sm table-fixed">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="px-3 py-2 w-12 text-center">No</th>
                                        <th class="px-3 py-2 w-64">Siswa</th>
                                        <?php foreach($mapel_terpilih->komponen as $komponen): ?>
                                            <th class="px-3 py-2 w-32 text-center"><?= htmlspecialchars($komponen['nama_komponen']) ?></th>
                                        <?php endforeach; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $no=1; foreach($siswa as $s): ?>
                                        <tr class="border-b">
                                            <td class="px-3 py-2 text-center"><?= $no++ ?></td>
                                            <td class="px-3 py-2 font-medium"><?= htmlspecialchars($s->nama) ?></td>
                                            <?php foreach($mapel_terpilih->komponen as $komponen): ?>
                                                <td class="px-3 py-2 text-center">
                                                    <input type="number" step="0.01" min="0" max="100"
                                                        name="nilai[<?= $s->id_enroll ?>][<?= $mapel_terpilih->id_kelas_mapel ?>][<?= $komponen['id_komponen'] ?>]"
                                                        value="<?= $this->Nilai_model->get_nilai_satu($s->id_enroll, $mapel_terpilih->id_mapel, $komponen['id_komponen']) ?>"
                                                        class="form-input w-20 text-center text-sm border rounded">
                                                </td>
                                            <?php endforeach; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>

                        <button type="submit" class="btn btn-primary w-25 rounded-lg mt-4">
                            Simpan Nilai
                        </button>
                        <a href="<?= base_url('nilai/daftar/'.$id_kelas.'/'.$id_ta.'/'.$id_mapel) ?>" class="btn btn-info ml-2 mt-4">
                            Lihat Daftar Nilai
                        </a>
                    </form>
                <?php else: ?>
                    <p class="text-red-500">Tidak ada komponen nilai untuk mapel ini. Silakan atur di menu Enroll Mapel.</p>
                <?php endif; ?>
            <?php else: ?>
                <p class="text-gray-600 text-sm">Data tidak tersedia.</p>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="intro-y box p-5 w-full bg-white rounded-lg shadow-sm">
            <p class="text-gray-600 text-sm">Pilih Kelas, Tahun Ajaran, dan Mapel terlebih dahulu.</p>
        </div>
    <?php endif; ?>
</div>

<script>
$(document).ready(function(){
    if ($('#nilai_terisi').length) {
        $('#nilai_terisi').DataTable({ "pageLength": 50 });
    }
});
</script>
<!-- BEGIN: Modal Import Excel -->
<div id="importExcel" class="modal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
        <!-- Header -->
        <div class="modal-header">
            <h2 class="font-medium text-base mr-auto">Import Data Nilai dari Excel</h2>
            <button type="button" class="btn-close" data-tw-dismiss="modal" aria-label="Close">
            <i data-lucide="x" class="w-4 h-4"></i>
            </button>
        </div>

        <div class="intro-y box p-5">
            <div class="col-span-12">
                    <div class="alert alert-warning flex items-center mb-4">
                        <i data-lucide="info" class="w-5 h-5 mr-2"></i>
                        Format harus sesuai template.
                        <a href="<?=base_url('nilai/exportexcel/'.$id_kelas.'/'.$id_ta.'/'.$id_mapel)?>" class="underline ml-1">
                        Unduh Template
                        </a>
                    </div>
                </div>
            
                <!-- HANYA form dengan class dropzone, TANPA input asli -->
                <form 
                id="importExcelForm" 
                action="<?= base_url('nilai/importExcel') ?>" 
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
        url: "<?= base_url('nilai/importExcel') ?>",
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