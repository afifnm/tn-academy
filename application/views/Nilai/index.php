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
                <form action="<?= base_url('nilai/importExcel'); ?>" method="post" enctype="multipart/form-data" id="importForm">
                    <div class="mb-4">
                        <label for="file_excel" class="form-label mb-3 block font-medium">Pilih File Excel</label>
                        <div class="relative">
                            <input type="file" 
                                   class="form-control block w-full text-sm text-slate-600 border border-slate-300 rounded-lg p-2.5 focus:ring-2 focus:ring-primary focus:border-primary cursor-pointer" 
                                   id="file_excel" 
                                   name="file_excel" 
                                   accept=".xls,.xlsx" 
                                   required>
                        </div>
                        <p class="text-slate-500 text-xs mt-2">
                            <i data-lucide="info" class="w-3 h-3 inline mr-1"></i>
                            Format yang didukung: .xls, .xlsx (maks. 10MB)
                        </p>
                        <div id="file-info" class="mt-3 p-3 bg-slate-50 rounded-lg hidden">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <i data-lucide="file-spreadsheet" class="w-5 h-5 text-success mr-2"></i>
                                    <div>
                                        <p class="text-sm font-medium text-slate-700" id="file-name"></p>
                                        <p class="text-xs text-slate-500" id="file-size"></p>
                                    </div>
                                </div>
                                <button type="button" id="file-remove" class="text-danger text-sm hover:underline">
                                    Hapus
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" class="btn btn-secondary" data-tw-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">
                            <i data-lucide="upload" class="w-4 h-4 mr-2"></i>
                            Import
                        </button>
                    </div>
                </form>
                
                <script>
                $(document).ready(function() {
                    const fileInput = document.getElementById('file_excel');
                    const fileInfo = document.getElementById('file-info');
                    const fileName = document.getElementById('file-name');
                    const fileSize = document.getElementById('file-size');
                    const fileRemove = document.getElementById('file-remove');
                    
                    // Initialize Lucide icons
                    if (typeof lucide !== 'undefined') {
                        lucide.createIcons();
                    }
                    
                    // Format file size
                    function formatFileSize(bytes) {
                        if (bytes === 0) return '0 Bytes';
                        const k = 1024;
                        const sizes = ['Bytes', 'KB', 'MB', 'GB'];
                        const i = Math.floor(Math.log(bytes) / Math.log(k));
                        return Math.round(bytes / Math.pow(k, i) * 100) / 100 + ' ' + sizes[i];
                    }
                    
                    // Handle file selection
                    fileInput.addEventListener('change', function() {
                        const file = this.files[0];
                        if (file) {
                            // Validate file type
                            const validExtensions = ['.xls', '.xlsx'];
                            const fileExtension = '.' + file.name.split('.').pop().toLowerCase();
                            
                            if (!validExtensions.includes(fileExtension)) {
                                alert('Format file tidak valid! Harus .xls atau .xlsx');
                                this.value = '';
                                fileInfo.classList.add('hidden');
                                return;
                            }
                            
                            // Validate file size (10MB)
                            if (file.size > 10 * 1024 * 1024) {
                                alert('Ukuran file terlalu besar! Maksimal 10MB');
                                this.value = '';
                                fileInfo.classList.add('hidden');
                                return;
                            }
                            
                            // Show file info
                            fileName.textContent = file.name;
                            fileSize.textContent = formatFileSize(file.size);
                            fileInfo.classList.remove('hidden');
                            
                            // Re-initialize icons
                            if (typeof lucide !== 'undefined') {
                                lucide.createIcons();
                            }
                        } else {
                            fileInfo.classList.add('hidden');
                        }
                    });
                    
                    // Remove file
                    if (fileRemove) {
                        fileRemove.addEventListener('click', function() {
                            fileInput.value = '';
                            fileInfo.classList.add('hidden');
                        });
                    }
                    
                    // Reset when modal is closed
                    $('#importExcel').on('hidden.bs.modal hidden.tw.modal', function() {
                        fileInput.value = '';
                        fileInfo.classList.add('hidden');
                    });
                });
                </script>
            </div>
        </div>
    </div>
</div>
<!-- END: Modal Import Excel -->