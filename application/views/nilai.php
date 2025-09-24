<div class="p-4">
    <h2 class="font-medium text-base mb-4">Kelola Nilai</h2>

    <?php if($this->session->flashdata('error')): ?>
        <div class="alert alert-danger mb-4"><?= $this->session->flashdata('error') ?></div>
    <?php endif; ?>

    <form id="formPilih" action="<?= base_url('nilai/input') ?>" method="GET" class="flex gap-4 items-end">
        <div>
            <label>Kelas:</label>
            <select name="id_kelas" class="form-select" required>
                <option value="">-- Pilih Kelas --</option>
                <?php foreach($kelas as $k): ?>
                    <option value="<?= $k['id_kelas'] ?>"><?= $k['nama_kelas'] ?></option>
                <?php endforeach; ?>

            </select>
        </div>
        <div>
            <label>Tahun Ajaran:</label>
            <select name="id_tahun_ajaran" class="form-select" required>
                <option value="">-- Pilih Tahun Ajaran --</option>
                <?php foreach($tahun_ajaran as $ta): ?>
                    <option value="<?= $ta['id_tahun_ajaran'] ?>"><?= $ta['tahun_ajaran'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Kelola Nilai</button>
    </form>
</div>

<script>
    $('#formPilih').submit(function(e){
        e.preventDefault();
        var kelas = $('select[name="id_kelas"]').val();
        var tahun = $('select[name="id_tahun_ajaran"]').val();
        if(kelas && tahun){
            window.location.href = "<?= base_url('nilai/input') ?>/"+kelas+"/"+tahun;
        }
    });
</script>
