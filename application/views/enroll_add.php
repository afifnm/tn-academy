<div class="intro-y box">
	<div class="flex flex-col sm:flex-row items-center p-5 border-b border-slate-200/60">
		<h2 class="font-medium text-base mr-auto">Tambah Enroll</h2>
	</div>
	<div id="input" class="p-5">
		<form action="<?=base_url('admin/enroll/save')?>" method="post">
            <div> 
                <label>Nama Siswa</label>
                <div class="mt-2"> <select data-placeholder="Cari Nama siswa" class="tom-select w-full" name="id_siswa" class="form-control" required>
                    <option value="">-- Pilih Siswa --</option>
                    <?php foreach ($siswa as $s): ?>
                        <option value="<?= $s->id_siswa ?>"><?= $s->nama ?></option>
                    <?php endforeach; ?>
                    </select> 
                </div>
            </div>

            <div class="mt-3">
                <label class="form-label">Kelas</label>
                <select name="id_kelas" class="form-control" required>
                    <option value="">-- Pilih Kelas --</option>
                    <?php foreach ($kelas as $k): ?>
                        <option value="<?= $k->id_kelas ?>"><?= $k->nama_kelas ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mt-3">
                <label class="form-label">Tahun Ajaran</label>
                <select name="id_ta" class="form-control" required>
                    <option value="">-- Pilih Tahun Ajaran --</option>
                    <?php foreach ($tahun_ajaran as $ta): ?>
                        <option value="<?= $ta->id_ta ?>"><?= $ta->tahun ?> (<?= $ta->semester ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mt-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-control" required>
                    <option value="aktif">Aktif</option>
                    <option value="nonaktif">Nonaktif</option>
                    <option value="pindah">Pindah</option>
                    <option value="lulus">Lulus</option>
                </select>
            </div>

            <div class="mt-5 text-right">
                <a href="<?=base_url('admin/enroll')?>" class="btn btn-outline-secondary w-20 mr-1">Batal</a>
                <button type="submit" class="btn btn-primary w-20">Simpan</button>
            </div>
        </form>
	</div>
</div>
