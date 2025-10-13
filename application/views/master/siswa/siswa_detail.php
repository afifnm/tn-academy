
<div class="grid grid-cols-12 gap-6">
	<!-- BEGIN: Profile Menu -->
	<div class="col-span-12 lg:col-span-4 2xl:col-span-3 flex lg:block flex-col-reverse">
		<div class="intro-y box mt-5">
			<div class="relative flex items-center p-5">
				<div class="w-12 h-12 image-fit">
					<img alt="Midone - HTML Admin Template" class="rounded-full" src="<?= !empty($siswa['foto']) ? base_url('assets/upload/foto_siswa/'.$siswa['foto']) : base_url('assets/dist/images/profile-15.jpg') ?>"">
				</div>
				<div class="ml-4 mr-auto">
					<div class="font-medium text-base"><?= $siswa['nama'] ?></div>
					<div class="text-slate-500"><?= $siswa['status'] ?></div>
				</div>
				
                
			</div>
            
			<div class="p-5 border-t border-slate-200/60 dark:border-darkmode-400">
                <a class="text-primary flex items-center font-medium tab-link active" href="javascript:;" data-tab="siswa">
                    <i data-lucide="star" class="w-4 h-4 mr-2"></i> Informasi Siswa
                </a>
                <a class="flex items-center mt-5 tab-link" href="javascript:;" data-tab="ortu">
                    <i data-lucide="user-check" class="w-4 h-4 mr-2"></i> Informasi Orang Tua
                </a>
                <a class="flex items-center mt-5 tab-link" href="javascript:;" data-tab="lain">
                    <i data-lucide="list" class="w-4 h-4 mr-2"></i> Informasi Lainnya
                </a>
                <!-- <a class="flex items-center mt-5 tab-link" href="javascript:;" data-tab="user">
                    <i data-lucide="settings" class="w-4 h-4 mr-2"></i> User Settings
                </a> -->
            </div>
			<div class="p-5 border-t border-slate-200/60 dark:border-darkmode-400 flex p-2 ">
                <a href="" class="py-1 px-1">
                	<button type="button" class="btn btn-primary">Nilai Raport</button>
                </a>
                <a href="<?=base_url('admin/siswa')?>" class="py-1 px-1 ml-auto">
                    <button type="button" class="btn btn-outline-secondary ">Kembali</button>

                </a>
			</div>
		</div>
	</div>
	<!-- END: Profile Menu -->
	<div class="col-span-12 lg:col-span-8 2xl:col-span-9">
        <!-- Tab Siswa -->
         
        <div id="tab-siswa" class="tab-content-block">
            <!-- Konten Informasi Siswa -->
            <div class="intro-y box lg:mt-5">
                <div class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        Informasi Siswa
                    </h2>
                </div>
                <form action="<?= base_url('admin/siswa/update_siswa/'.$siswa['id_siswa']) ?>" method="POST">
                    <div class="p-5">
                        <input type="hidden" name="id_siswa" value="<?= $siswa['id_siswa'] ?>">
                        <div class="flex flex-col-reverse xl:flex-row flex-col">
                            <div class="flex-1 mt-6 xl:mt-0">
                                <div class="">
                                    <div class="col-span-12 2xl:col-span-6">
                                        <div class="grid grid-cols-12 gap-x-5">
                                            <div class="col-span-12 xl:col-span-6">
                                                <label for="update-profile-form-1" class="form-label">NISN Siswa</label>
                                                <input id="update-profile-form-1" type="text" class="form-control"
                                                    placeholder="Input text" value="<?=$siswa['nisn']?>" name="nisn">
                                            </div>
                                            <div class="col-span-12 xl:col-span-6">
                                                <label for="update-profile-form-10" class="form-label">NIS Siswa</label>
                                                <input id="update-profile-form-10" type="text" class="form-control"
                                                    placeholder="Input text" value="<?=$siswa['nis']?>" name="nis">
                                            </div>
                                        </div>
                                        <div class="mt-3">
                                            <label for="update-profile-form-11" class="form-label">Nama Lengkap</label>
                                            <input id="update-profile-form-11" type="text" class="form-control"
                                                placeholder="Input text" value="<?=$siswa['nama']?>" name="nama">
                                        </div>
                                        <div class="mt-3">
                                            <label for="update-profile-form-12" class="form-label">Email</label>
                                            <input id="update-profile-form-12" type="text" class="form-control"
                                                placeholder="Input text" value="<?=$siswa['email']?>" name="email">
                                        </div>
                                        <div class="mt-3">
                                            <label for="update-profile-form-jk" class="form-label">Jenis Kelamin</label>
                                            <select id="update-profile-form-jk" class="form-select" name="jenis_kelamin">
                                                <option value="Laki-laki" <?= $siswa['jenis_kelamin']=='Laki-laki'?'selected':'' ?>>Laki-laki</option>
                                                <option value="Perempuan" <?= $siswa['jenis_kelamin']=='Perempuan'?'selected':'' ?>>Perempuan</option>
                                            </select>
                                        </div>
                                        <div class="mt-3">
                                            <label class="form-label">Agama</label>
                                            <select class="form-select w-full" name="agama">
                                                <option value="islam" <?= $siswa['agama']=='islam'?'selected':'' ?>>Islam</option>
                                                <option value="kristen" <?= $siswa['agama']=='kristen'?'selected':'' ?>>Kristen</option>
                                                <option value="katolik" <?= $siswa['agama']=='katolik'?'selected':'' ?>>Katolik</option>
                                                <option value="hindu" <?= $siswa['agama']=='hindu'?'selected':'' ?>>Hindu</option>
                                                <option value="budha" <?= $siswa['agama']=='budha'?'selected':'' ?>>Budha</option>
                                                <option value="konghucu" <?= $siswa['agama']=='konghucu'?'selected':'' ?>>Konghucu</option>
                                            </select>
                                        </div>

                                        <div class="mt-3">
                                            <label class="form-label">Jalur Pendidikan</label>
                                            <select class="form-select w-full mb-3" name="jalur_pendidikan">
                                                <option value="reguler" <?= $siswa['jalur_pendidikan']=='reguler'?'selected':'' ?>>Reguler</option>
                                                <option value="beasiswa" <?= $siswa['jalur_pendidikan']=='beasiswa'?'selected':'' ?>>Beasiswa</option>
                                                <option value="kontribusi" <?= $siswa['jalur_pendidikan']=='kontribusi'?'selected':'' ?>>Kontribusi Khusus</option>
                                            </select>
                                        </div>

                                        <div class="grid grid-cols-12 gap-x-5">
                                            <div class="col-span-12 xl:col-span-6">
                                                <label class="form-label">Tempat Lahir</label>
                                                <input type="text" class="form-control w-full mb-3" name="tempat_lahir" value="<?= $siswa['tempat_lahir'] ?>">

                                                <label class="form-label">Tahun Masuk</label>
                                                <input type="number" class="form-control w-full mb-3" name="thn_masuk" min="2000" max="2025" value="<?= $siswa['thn_masuk'] ?>">

                                                <label class="form-label">Graha</label>
                                                <input type="text" class="form-control w-full mb-3" name="graha" value="<?= $siswa['graha'] ?>">
                                            </div>
                                            <div class="col-span-12 xl:col-span-6">
                                                <label class="form-label">Tanggal Lahir</label>
                                                <input type="date" class="form-control w-full mb-3" name="tgl_lahir" value="<?= $siswa['tgl_lahir'] ?>">

                                                <label class="form-label">Status</label>
                                                <select class="form-select w-full mb-3" name="status">
                                                    <option value="aktif" <?= $siswa['status']=='aktif'?'selected':'' ?>>Aktif</option>
                                                    <option value="lulus" <?= $siswa['status']=='lulus'?'selected':'' ?>>Lulus</option>
                                                    <option value="keluar" <?= $siswa['status']=='keluar'?'selected':'' ?>>Keluar</option>
                                                </select>

                                                <label class="form-label">Provinsi</label>
                                                <input type="text" class="form-control w-full mb-3" name="nama_provinsi" value="<?= $siswa['nama_provinsi'] ?? $siswa['nama_provinsi'] ?>">
                                            </div>
                                        </div>
                                                                                
                                                                        
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary w-35 mt-3">Simpan Perubahan</button>
                            </div>
                            
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- Tab Orang Tua -->
		<div id="tab-ortu" class="tab-content-block hidden">
            <!-- Konten Informasi Orang Tua -->
            <div class="intro-y box mt-5">
                <div class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                    <h2 class="font-medium text-base mr-auto">
                        Informasi Orang Tua
                    </h2>
                </div>
                <form action="<?= base_url('admin/siswa/update_ortu/'.$siswa['id_siswa']) ?>" method="POST">
                    <div class="p-5">
                        <div class="grid grid-cols-12 gap-x-5">
                            <div class="col-span-12 xl:col-span-6">
                                <div>
                                <label class="form-label">Nama Ayah</label>
                                <input type="text" class="form-control w-full mb-3" name="nama_ayah" value="<?= $siswa['nama_ayah'] ?>">

                                </div>
                                <div class="mt-3">
                                    <label class="form-label">Pekerjaan Ayah</label>
                                    <label class="form-label">Pekerjaan Ayah</label>
                                    <input type="text" class="form-control w-full mb-3" name="pekerjaan_ayah" value="<?= $siswa['pekerjaan_ayah'] ?>">                           
                                </div>
                                <div class="mt-3">
                                    <label class="form-label">Penghasilan Ayah</label>
                                    <select class="form-select w-full mb-3" name="penghasilan_ayah">
                                        <option value="0 / Tidak punya penghasilan" <?= $siswa['penghasilan_ayah']=='0 / Tidak punya penghasilan'?'selected':'' ?>>0 / Tidak punya penghasilan</option>
                                        <option value="< 1 juta" <?= $siswa['penghasilan_ayah']=='< 1 juta'?'selected':'' ?>>< 1 juta</option>
                                        <option value="1 - 3 juta" <?= $siswa['penghasilan_ayah']=='1 - 3 juta'?'selected':'' ?>>1 - 3 juta</option>
                                        <option value="3 - 5 juta" <?= $siswa['penghasilan_ayah']=='3 - 5 juta'?'selected':'' ?>>3 - 5 juta</option>
                                        <option value="5 - 10 juta" <?= $siswa['penghasilan_ayah']=='5 - 10 juta'?'selected':'' ?>>5 - 10 juta</option>
                                        <option value="10 - 15 juta" <?= $siswa['penghasilan_ayah']=='10 - 15 juta'?'selected':'' ?>>10 - 15 juta</option>
                                        <option value="> 15 juta" <?= $siswa['penghasilan_ayah']=='> 15 juta'?'selected':'' ?>>> 15 juta</option>
                                    </select>
                                </div>

                            </div>
                            <div class="col-span-12 xl:col-span-6">
                                <div class="col-span-12 xl:col-span-6">
                                    <label class="form-label">Nama Ibu</label>
                                    <input type="text" class="form-control w-full mb-3" name="nama_ibu" value="<?= $siswa['nama_ibu'] ?>">

                                    <label class="form-label">Pekerjaan Ibu</label>
                                    <input type="text" class="form-control w-full mb-3" name="pekerjaan_ibu" value="<?= $siswa['pekerjaan_ibu'] ?>">

                                    <label class="form-label">Penghasilan Ibu</label>
                                    <select class="form-select w-full mb-3" name="penghasilan_ibu">
                                        <option value="0 / Tidak punya penghasilan" <?= $siswa['penghasilan_ibu']=='0 / Tidak punya penghasilan'?'selected':'' ?>>0 / Tidak punya penghasilan</option>
                                        <option value="< 1 juta" <?= $siswa['penghasilan_ibu']=='< 1 juta'?'selected':'' ?>>< 1 juta</option>
                                        <option value="1 - 3 juta" <?= $siswa['penghasilan_ibu']=='1 - 3 juta'?'selected':'' ?>>1 - 3 juta</option>
                                        <option value="3 - 5 juta" <?= $siswa['penghasilan_ibu']=='3 - 5 juta'?'selected':'' ?>>3 - 5 juta</option>
                                        <option value="5 - 10 juta" <?= $siswa['penghasilan_ibu']=='5 - 10 juta'?'selected':'' ?>>5 - 10 juta</option>
                                        <option value="10 - 15 juta" <?= $siswa['penghasilan_ibu']=='10 - 15 juta'?'selected':'' ?>>10 - 15 juta</option>
                                        <option value="> 15 juta" <?= $siswa['penghasilan_ibu']=='> 15 juta'?'selected':'' ?>>> 15 juta</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- Tab Lainnya -->
        <div id="tab-lain" class="tab-content-block hidden">
            <form action="<?= base_url('admin/siswa/update_lain/'.$siswa['id_siswa']) ?>" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="id_siswa" value="<?= $siswa['id_siswa'] ?>">
                <div class="intro-y box lg:mt-5">
                    <div class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                        <h2 class="font-medium text-base mr-auto">Informasi Lain</h2>
                    </div>
                    <div class="p-5">
                        <div class="flex flex-col-reverse xl:flex-row flex-col">
                            <div class="flex-1 mt-6 xl:mt-0">
                                <div class="grid grid-cols-12 gap-x-5">
                                    <div class="col-span-12 2xl:col-span-6">
                                        <label class="form-label">Cita-cita</label>
                                        <input type="text" class="form-control mb-3" name="cita_cita" value="<?= $siswa['cita_cita'] ?>" placeholder="cita-cita siswa">

                                        <label class="form-label">Asal Sekolah</label>
                                        <input type="text" class="form-control mb-3" name="nama_smp" value="<?= $siswa['nama_smp'] ?>" placeholder="Asal Sekolah">

                                        <label class="form-label">Tinggi (cm)</label>
                                        <input type="number" class="form-control mb-3" name="tinggi" value="<?= $siswa['tinggi'] ?>" placeholder="178">

                                        <label class="form-label">Berat Badan (kg)</label>
                                        <input type="number" class="form-control mb-3" name="berat_badan" value="<?= $siswa['berat_badan'] ?>" placeholder="40">

                                        <label class="form-label">Hobi</label>
                                        <input type="text" class="form-control mb-3" name="hobi" value="<?= $siswa['hobi'] ?>" placeholder="hobi">
                                    </div>
                                </div>
                            </div>
                            <div class="w-60 mx-auto xl:mr-0 xl:ml-6">
                                <label class="mb-3">Foto Siswa</label>
                                <div class="border-2 border-dashed shadow-sm border-slate-200/60 dark:border-darkmode-400 rounded-md p-5 mt-3">
                                    <div class="h-40 relative image-fit cursor-pointer zoom-in mx-auto">
                                        <img id="previewFoto" class="rounded-md object-cover w-full h-full"
                                            alt="Preview Foto Siswa"
                                            src="<?= !empty($siswa['foto']) ? base_url('assets/upload/foto_siswa/'.$siswa['foto']) : base_url('assets/dist/images/profile-15.jpg') ?>">
                                        <?php if (!empty($siswa['foto'])): ?>
                                        <div id="removeFoto" title="Hapus foto ini?" 
                                            class="tooltip w-5 h-5 flex items-center justify-center absolute rounded-full text-white bg-danger right-0 top-0 -mr-2 -mt-2 cursor-pointer">
                                            <i data-lucide="x" class="w-4 h-4"></i>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="mx-auto cursor-pointer relative mt-5">
                                        <button type="button" class="btn btn-primary w-full" onclick="document.getElementById('fotoInput').click()">Ganti Foto</button>
                                        <input type="file" id="fotoInput" accept="image/*" name="foto"
                                            class="w-full h-full top-0 left-0 absolute opacity-0 cursor-pointer">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary w-35 mt-3">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
            
        
		
	</div>
</div>
<script>
document.querySelectorAll('.tab-link').forEach(function(link) {
    link.addEventListener('click', function() {
        // Remove active class dari semua link
        document.querySelectorAll('.tab-link').forEach(function(l) {
            l.classList.remove('text-primary', 'font-medium', 'active');
        });
        // Tambahkan active class ke link yang diklik
        this.classList.add('text-primary', 'font-medium', 'active');

        // Sembunyikan semua tab content
        document.querySelectorAll('.tab-content-block').forEach(function(tab) {
            tab.classList.add('hidden');
        });
        // Tampilkan tab content sesuai data-tab
        document.getElementById('tab-' + this.getAttribute('data-tab')).classList.remove('hidden');
    });
});
</script>


<!-- JS Pekerjaan Lainnya -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.pekerjaan-lainnya').forEach(function(select) {
        const targetId = select.dataset.target;
        const input = document.getElementById(targetId);

        input.classList.add('hidden');
        input.required = false;

        select.addEventListener('change', function() {
            if(this.value === 'Lainnya'){
                input.classList.remove('hidden'); // tampilkan input
                input.required = true;
            } else {
                input.classList.add('hidden'); // sembunyikan input
                input.required = false;
            }
        });
    });
});
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Aktifkan tab sesuai query string
    const urlParams = new URLSearchParams(window.location.search);
    const tab = urlParams.get('tab');
    if(tab) {
        document.querySelectorAll('.tab-link').forEach(function(l) {
            l.classList.remove('text-primary', 'font-medium', 'active');
        });
        document.querySelectorAll('.tab-content-block').forEach(function(tabContent) {
            tabContent.classList.add('hidden');
        });
        // Aktifkan tab sesuai query
        const activeLink = document.querySelector('.tab-link[data-tab="'+tab+'"]');
        const activeContent = document.getElementById('tab-'+tab);
        if(activeLink && activeContent) {
            activeLink.classList.add('text-primary', 'font-medium', 'active');
            activeContent.classList.remove('hidden');
        }
    }
});
</script>

<script>
	document.getElementById('fotoInput').addEventListener('change', function (e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('previewFoto').src = e.target.result;
            document.getElementById('removeFoto').classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
});

// Tombol hapus foto
document.getElementById('removeFoto').addEventListener('click', function () {
    document.getElementById('fotoInput').value = ""; // reset input
    document.getElementById('previewFoto').src = "<?=base_url('assets/')?>dist/images/profile-15.jpg";
    this.classList.add('hidden');
});
</script>