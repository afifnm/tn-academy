<div class="p-4">
    <div class="intro-y flex items-center mt-2 mb-5">
        <h2 class="text-lg font-medium"><?= $title ?></h2>
    </div>

    <div class="intro-y box p-5">
        <form method="POST" action="<?= base_url('admin/enrollmapel/update_detail') ?>">
            <input type="hidden" name="id_enroll_mapel" value="<?= $enroll['id_enroll_mapel'] ?>">
            <input type="hidden" name="id_ta" value="<?= $enroll['id_ta'] ?>">
            <input type="hidden" name="id_kelas" value="<?= $enroll['id_kelas'] ?>">

            <!-- Info Dasar -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div>
                    <label class="form-label">Mata Pelajaran</label>
                    <input type="text" class="form-control" value="<?= $enroll['nama_mapel'] ?>" disabled>
                </div>
                <div>
                    <label class="form-label">Kelas</label>
                    <input type="text" class="form-control" value="<?= $enroll['nama_kelas'] ?>" disabled>
                </div>
                <div>
                    <label class="form-label">Tahun Ajaran</label>
                    <input type="text" class="form-control" value="<?= $enroll['tahun'] ?> - <?= $enroll['semester'] ?>" disabled>
                </div>
            </div>

            <!-- Guru -->
            <div class="form-group mb-4">
                <label class="form-label">Guru Pengajar</label>
                <select name="id_guru" class="form-select">
                    <option value="">-- Pilih Guru --</option>
                    <?php foreach ($guru as $g): ?>
                        <option value="<?= $g['id_guru'] ?>" 
                            <?= ($g['id_guru'] == ($enroll['id_guru'] ?? '')) ? 'selected' : '' ?>>
                            <?= $g['nama_guru'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

           <!-- Komponen  -->
            <div class="form-group mb-6">
                <label class="form-label">Komponen Penilaian</label>
                <div class="mt-2 space-y-2 max-h-40 overflow-y-auto p-2 border rounded">
                    <?php
                    $existing_komponen = $this->EnrollMapel_model->get_nama_komponen_by_enroll($enroll['id_enroll_mapel']);
                    ?>
                    <?php if (!empty($existing_komponen)): ?>
                        <?php foreach ($existing_komponen as $k): ?>
                            <div class="flex items-center">
                                <input type="checkbox" 
                                    name="komponen_baru[]" 
                                    value="<?= htmlspecialchars($k['nama_komponen']) ?>"
                                    id="komponen_<?= $k['id_komponen'] ?>"
                                    checked>
                                <label for="komponen_<?= $k['id_komponen'] ?>" class="ml-2">
                                    <?= htmlspecialchars($k['nama_komponen']) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <!-- Input tambahan -->
                    <div class="mt-3">
                        <label class="text-sm">Tambah Komponen Baru:</label>
                        <input type="text" 
                            name="komponen_baru[]" 
                            placeholder="Misal: UTS, UAS, PAS, Praktik, dll" 
                            class="form-control w-full mt-1">
                    </div>
                    <div class="mt-1">
                        <input type="text" 
                            name="komponen_baru[]" 
                            placeholder="Tambahkan lagi jika perlu" 
                            class="form-control w-full mt-1">
                    </div>
                </div>
                <small class="text-slate-500">Centang komponen lama atau tambahkan komponen baru di bawah.</small>
            </div>

            <div class="flex justify-between">
                <a href="<?= site_url('admin/enrollmapel/filter?id_ta=' . $filter['id_ta'] . '&id_kelas=' . $filter['id_kelas']) ?>" 
                   class="btn btn-secondary">← Kembali ke Enroll</a>
                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>