<div class="intro-y box mt-1 ">
    <form action="<?= base_url('admin/siswa/save') ?>" method="POST" enctype="multipart/form-data">
        <!-- Tab Header -->
        <ul id="tabMenu" class="nav nav-link-tabs mt-4" role="tablist">
			<!-- Step 1 -->
			<li id="step-1-tab" class="nav-item flex-1" role="presentation">
				<button class="nav-link w-full py-3 active flex items-center justify-center gap-2"
					data-tw-toggle="pill" data-tw-target="#step-1" type="button" role="tab" aria-controls="step-1"	aria-selected="true">
					<span class="w-5 h-5 flex items-center justify-center rounded-full bg-primary text-white text-sm">
						1
					</span>
					<span class="">Data Siswa</span>

				</button>
			</li>


			<!-- Step 2 -->
			<li id="step-2-tab" class="nav-item flex-1" role="presentation">
				<button class="nav-link w-full py-3 flex items-center justify-center gap-2"	data-tw-toggle="pill" data-tw-target="#step-2" type="button" role="tab" aria-controls="step-2" aria-selected="false">
					<span class="w-5 h-5 flex items-center justify-center rounded-full bg-slate-300 text-slate-600 text-sm">
						2
					</span>
					<span class="">Data Orang Tua</span>

				</button>
			</li>

			<!-- Step 3 -->
			<li id="step-3-tab" class="nav-item flex-1" role="presentation">
				<button class="nav-link w-full py-3 flex items-center justify-center gap-2"	data-tw-toggle="pill" data-tw-target="#step-3" type="button" role="tab" aria-controls="step-3" aria-selected="false">
					<span class="w-5 h-5  flex items-center justify-center rounded-full bg-slate-300 text-slate-600 text-sm">
						3
					</span>
					<span class="">Lainnya</span>
				</button>
			</li>
		</ul>


        <!-- Tab Content -->
        <div class="tab-content p-5">
            <!-- Step 1 -->

			<div id="step-1" class="tab-pane px-5 py-2 active" role="tabpanel" aria-labelledby="step-1-tab">
				
				<label class="form-label">NISN</label>
				<input type="number" class="form-control w-full mb-3" name="nisn" placeholder="NISN Siswa" required>

				<label class="form-label">NIS</label>
				<input type="number" class="form-control w-full mb-3" name="nis" placeholder="NIS Siswa" required>

				<label class="form-label">Nama Siswa</label>
				<input type="text" class="form-control w-full mb-3" name="nama" placeholder="Nama Lengkap" required>

				<label class="form-label">Email</label>
				<input type="email" class="form-control w-full mb-3" name="email" placeholder="Johndoe@gmal.com" required>

				<label class="form-label">Jenis Kelamin</label>
				<select class="form-select w-full mb-3" name="jenis_kelamin" required>
					<option value="">-- Pilih Jenis Kelamin --</option>
					<option value="L">Laki-laki</option>
					<option value="P">Perempuan</option>
				</select>

				<label class="form-label">Agama</label>
				<select class="form-select w-full mb-3" name="agama">
					<option value="islam">Islam</option>
					<option value="kristen">Kristen</option>
					<option value="katolik">Katolik</option>
					<option value="hindu">Hindu</option>
					<option value="budha">Budha</option>
					<option value="konghucu">Konghucu</option>
				</select>

				<label class="form-label">Jalur Pendidikan</label>
				<select class="form-select w-full mb-3" name="jalur_pendidikan">
					<option value="">-- Pilih Jalur Pendidikan --</option>
					<option value="reguler">Reguler</option>
					<option value="beasiswa">Beasiswa</option>
					<option value="kontribusi">Kontribusi Khusus</option>
				</select>

				<label class="form-label">Tempat Lahir</label>
				<input type="text" class="form-control w-full mb-3" name="tempat_lahir" placeholder="Tempat Lahir">

				<label class="form-label">Tanggal Lahir</label>
				<input type="date" class="form-control w-full mb-3" name="tgl_lahir">

				<label class="form-label">Tahun Masuk</label>
				<input type="number" class="form-control w-full mb-3" name="thn_masuk" min="2000" max="2025" placeholder="2025">

				<label class="form-label">Status</label>
				<select class="form-select w-full mb-3" name="status">
					<option value="">-- Pilih Status Siswa --</option>
					<option value="aktif">Aktif</option>
					<option value="lulus">Lulus</option>
					<option value="keluar">Keluar</option>
				</select>
				<label class="form-label">Graha</label>
				<input type="text" class="form-control w-full mb-3" name="graha" placeholder="Graha">
				<label class="form-label">Provinsi</label>
				<input type="text" class="form-control w-full mb-3" name="nama_provinsi" placeholder="Provinsi">

				<div class="text-right mt-5">
					<button type="button" class="btn btn-primary next">Selanjutnya</button>
				</div>
			</div>

			<!-- Step 2 -->
			<div id="step-2" class="tab-pane px-5 py-2 !w-full max-w-full" role="tabpanel" aria-labelledby="step-2-tab">
				<label class="form-label">Nama Ayah</label>
				<input type="text" class="form-control w-full mb-3" name="nama_ayah" placeholder="Nama Ayah">

				<label class="form-label">Pekerjaan Ayah</label>
				<select class="form-select w-full mb-3 pekerjaan-lainnya" data-target="pekerjaan_ayah_lain" name="pekerjaan_ayah" required>
					<option value="">-- Pilih Pekerjaan --</option>
					<option value="PNS">PNS</option>
					<option value="Petani">Petani</option>
					<option value="TNI/Polri">TNI/Polri</option>
					<option value="Guru/Dosen">Guru/Dosen</option>
					<option value="Karyawan Swasta">Karyawan Swasta</option>
					<option value="Wiraswasta">Wiraswasta</option>
					<option value="Lainnya">Lainnya</option>
				</select>
				<input type="text" class="form-control w-full mb-3" id="pekerjaan_ayah_lain" name="pekerjaan_ayah_lain" placeholder="Tulis pekerjaan lain">


				<label class="form-label">Penghasilan Ayah</label>
				<select class="form-select w-full mb-3" name="penghasilan_ayah">
					<option value="0 / Tidak punya penghasilan">0 / Tidak punya penghasilan</option>
					<option value="< 1 juta">&lt; 1 juta</option>
					<option value="1 - 3 juta">1 - 3 juta</option>
					<option value="3 - 5 juta">3 - 5 juta</option>
					<option value="5 - 10 juta">5 - 10 juta</option>
					<option value="10 - 15 juta">10 - 15 juta</option>
					<option value="> 15 juta">&gt; 15 juta</option>
				</select>

				<label class="form-label">Nama Ibu</label>
				<input type="text" class="form-control w-full mb-3" name="nama_ibu" placeholder="Nama Ibu">

				<label class="form-label">Pekerjaan Ibu</label>
				<select class="form-select mb-3 w-full pekerjaan-lainnya" data-target="pekerjaan_ibu_lain" name="pekerjaan_ibu" required>
					<option value="">-- Pilih Pekerjaan --</option>
					<option value="Ibu Rumah Tangga">Ibu Rumah Tangga</option>
					<option value="PNS">PNS</option>
					<option value="Petani">Petani</option>
					<option value="Guru/Dosen">Guru/Dosen</option>
					<option value="Karyawan Swasta">Karyawan Swasta</option>
					<option value="Wiraswasta">Wiraswasta</option>
					<option value="Lainnya">Lainnya</option>
				</select>
				<input type="text" class="form-control w-full mb-3 d-none" id="pekerjaan_ibu_lain" name="pekerjaan_ibu_lain" placeholder="Tulis pekerjaan lain">
				
				<label class="form-label">Penghasilan Ibu</label>
				<select class="form-select w-full mb-3" name="penghasilan_ibu">
					<option value="0 / Tidak punya penghasilan">0 / Tidak punya penghasilan</option>
					<option value="< 1 juta">&lt; 1 juta</option>
					<option value="1 - 3 juta">1 - 3 juta</option>
					<option value="3 - 5 juta">3 - 5 juta</option>
					<option value="5 - 10 juta">5 - 10 juta</option>
					<option value="10 - 15 juta">10 - 15 juta</option>
					<option value="> 15 juta">&gt; 15 juta</option>
				</select>

				<div class="text-right mt-5">
					<button type="button" class="btn btn-secondary prev mr-2">Sebelumnya</button>
					<button type="button" class="btn btn-primary next">Selanjutnya</button>
				</div>
			</div>
			<!-- Step 3 -->
			<div id="step-3" class="tab-pane px-5 py-2" role="tabpanel" aria-labelledby="step-3-tab">
				<div class="lg:mt-5">
					<div class="flex flex-col-reverse xl:flex-row flex-col">
						<div class="flex-1 mt-6 xl:mt-0">
							<div class="grid grid-cols-12 gap-x-5">
								<div class="col-span-12 2xl:col-span-6">
									<div>
										<label class="form-label">Cita-cita</label>
										<input type="text" class="form-control mb-3" name="cita_cita" placeholder="cita-cita siswa">

										<label class="form-label">Asal Sekolah</label>
										<input type="text" class="form-control mb-3" name="nama_smp" placeholder="Asal Sekolah">

										<label class="form-label">Tinggi (cm)</label>
										<input type="number" class="form-control mb-3" name="tinggi" placeholder="178">

										<label class="form-label">Berat Badan (kg)</label>
										<input type="number" class="form-control mb-3" name="berat_badan" placeholder="40">

										<label class="form-label">Hobi</label>
										<input type="text" class="form-control mb-3" name="hobi" placeholder="hobi">											
									</div>
									
								</div>
								
							</div>
						</div>
						<div class="w-60 mx-auto xl:mr-0 xl:ml-6 mt-12">
							<label for="" class="mb-3">Tambah Foto Siswa (Opsional)</label>
							<div class="border-2 border-dashed shadow-sm border-slate-200/60 dark:border-darkmode-400 rounded-md p-5 mt-3 ">
        
								<!-- Preview -->
								<div class="h-40 relative image-fit cursor-pointer zoom-in mx-auto">
									<img id="previewFoto" class="rounded-md object-cover w-full h-full" 
										alt="Preview Foto Siswa" 
										src="<?=base_url('assets/')?>dist/images/profile-15.jpg">
									<div id="removeFoto" title="Hapus foto ini?" 
										class="hidden tooltip w-5 h-5 flex items-center justify-center absolute rounded-full text-white bg-danger right-0 top-0 -mr-2 -mt-2 cursor-pointer">
										<i data-lucide="x" class="w-4 h-4"></i>
									</div>
								</div>

								<!-- Input File -->
								<div class="mx-auto cursor-pointer relative mt-5">
									<button type="button" class="btn btn-primary w-full">Pilih Foto</button>
									<input type="file" id="fotoInput" accept="image/*" name="foto"
										class="w-full h-full top-0 left-0 absolute opacity-0 cursor-pointer">
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- Tombol Navigasi -->
				<div class="text-right mt-5">
					<button type="button" class="btn btn-secondary prev mr-2">Sebelumnya</button>
					<a href="<?= base_url('admin/siswa') ?>" class="btn btn-danger mr-2">Cancel</a>
					<button type="submit" class="btn btn-success">Simpan</button>
				</div>
			</div>
		
        </div>
    </form>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const panes = document.querySelectorAll(".tab-pane");

    panes.forEach(pane => {
        const observer = new MutationObserver(() => {
            if (pane.style.width) {
                pane.style.width = "";
                pane.style.maxWidth = "";
            }
        });
        observer.observe(pane, { attributes: true, attributeFilter: ["style"] });
    });
});
</script>


<!-- JS Tab Control -->
<script>
document.addEventListener("DOMContentLoaded", function () {
    const tabs = document.querySelectorAll("[data-tw-toggle='pill']");

	function updateTabCircles() {
        tabs.forEach(tab => {
            let circle = tab.querySelector("span:first-child");
            if (tab.classList.contains("active")) {
                circle.classList.remove("bg-slate-300", "text-slate-600");
                circle.classList.add("bg-primary", "text-white");
            } else {
                circle.classList.remove("bg-primary", "text-white");
                circle.classList.add("bg-slate-300", "text-slate-600");
            }
        });
    }

    updateTabCircles();

    tabs.forEach(tab => {
        tab.addEventListener("click", () => {
            setTimeout(updateTabCircles, 50); 
        });
    });

    function getActiveIndex() {
        return Array.from(tabs).findIndex(tab => tab.classList.contains("active"));
    }

    // Next
    document.querySelectorAll(".next").forEach(btn => {
        btn.addEventListener("click", () => {
            let current = getActiveIndex();
            if (current < tabs.length - 1) {
                tabs[current + 1].click();
            }
        });
    });

    // Prev
    document.querySelectorAll(".prev").forEach(btn => {
        btn.addEventListener("click", () => {
            let current = getActiveIndex();
            if (current > 0) {
                tabs[current - 1].click();
            }
        });
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

 <!-- JS Preview Foto -->
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