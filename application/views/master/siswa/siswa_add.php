<div class="intro-y box lg:mt-2">
	<div class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
		<h2 class="font-medium text-base mr-auto">
            Tambah Data Siswa
        </h2>
	</div>
	<div class="p-5">
		<div class="flex flex-col-reverse xl:flex-row flex-col">
			<div class="flex-1 mt-6 xl:mt-0">
				<div class="grid grid-cols-12 gap-x-5">
					<div class="col-span-12 2xl:col-span-6">
						<div>
							<label for="" class="form-label">NISN:</label>
							<input id="" type="text" class="form-control" placeholder="NISN Siswa" name ="nisn" >
						</div>
						<div class="mt-3">
							<label for="" class="form-label">Nama Siswa: </label>
							<input type="text" name="nama" id="" class="form-control" placeholder="Nama Siswa" >
						</div>
                        <div class="mt-3">
							 <label class="form-label">Tanggal Lahir:</label>
                            <input type="text" class="datepicker form-control" data-single-mode="true" name="tgl_lahir" required>
						</div>
                        <div class="mt-3">
                            <label class="form-label">Tahun Masuk:</label>
                            <input type="number" class="form-control" name="thn_masuk" placeholder="Tahun Masuk" min="2000" max="2025" required>
                        </div>
                        
					</div>
					<div class="col-span-12 2xl:col-span-6">
						<div class="mt-3 2xl:mt-0">
							<label for="" class="form-label">Status Siswa:</label>
							<select id="" class="form-select w-full"  name="status">
								<option value="aktif">Aktif</option>
                                <option value="lulus">Lulus</option>
                                <option value="keluar">Keluar</option>
							</select>
						</div>
						<div class="mt-3">
							<label for="" class="form-label">Nomor Telepon Rumah:</label>
							<input id="" type="text" class="form-control" placeholder="Input text" name="tlp">
						</div>
					</div>
					<div class="col-span-12">
						<div class="mt-3">
							<label for="" class="form-label">Alamat Siswa:</label>
							<textarea id="" class="form-control" name="alamat" rows="3"
								placeholder="Adress"></textarea>
						</div>
					</div>
                    <div class="col-span-12 mt-3"> 
                        <p for="" class="form-label">Data Orang Tua:</p>
                        
                    </div>
                    <div class="col-span-12">
                        <label for="" class="form-label">Nama Ayah:</label>
                        <input id="" type="text" class="form-control" name="ayah" placeholder="Nama Ayah">
					</div>
                    <div class="col-span-12">
                        <div class="mt-3">
                            <label for="" class="form-label">Nama Ibu:</label>
                            <input id="" type="text" class="form-control" name="ibu" placeholder="nama">
                        </div>
					</div>
                    
				</div>
                <div class="text-right mt-5">
                    <a href="<?=base_url('admin/siswa')?>">
                        <button type="button" class="btn btn-danger w-20 mt-3">Cancel</button>

                    </a>
                    <button type="button" class="btn btn-primary w-20 mt-3">Save</button>
                </div>
				
			</div>
			
		</div>
	</div>
</div>
