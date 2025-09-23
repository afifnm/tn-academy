<div class="p-6">
    <h1 class="text-2xl font-bold mb-4"><?= $title ?></h1>

    <!-- Filter Form -->
    <form method="GET" action="" class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium">Tahun Ajaran</label>
            <select name="tahun_ajaran" class="w-full rounded-lg border-gray-300">
                <?php foreach ($tahun_ajaran as $ta): ?>
                    <option value="<?= $ta['id_ta'] ?>"><?= $ta['tahun'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium">Kelas</label>
            <select name="kelas" class="w-full rounded-lg border-gray-300">
                <?php foreach ($kelas as $k): ?>
                    <option value="<?= $k['id_kelas'] ?>"><?= $k['nama_kelas'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="flex items-end">
            <button type="submit"
                class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Tampilkan</button>
        </div>
    </form>

    <!-- Tabel Enroll -->
    <div class="bg-white shadow rounded-lg overflow-hidden">
        <table class="min-w-full text-sm text-left border-collapse">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="px-4 py-2 border">NIS</th>
                    <th class="px-4 py-2 border">Nama Siswa</th>
                    <th class="px-4 py-2 border">Kelas</th>
                    <th class="px-4 py-2 border">Tahun Ajaran</th>
                    <th class="px-4 py-2 border text-center">Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($enroll)): ?>
                    <?php foreach ($enroll as $row): ?>
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-2 border"><?= $row['nisn'] ?></td>
                            <td class="px-4 py-2 border"><?= $row['nama'] ?></td>
                            <td class="px-4 py-2 border"><?= $row['nama_kelas'] ?></td>
                            <td class="px-4 py-2 border"><?= $row['tahun'] ?> <?= $row['semester'] ?></td>
                            <td class="px-4 py-2 border text-center">
                                <a href="#" class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600">Edit</a>
                                <a href="#" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">Hapus</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center py-4">Belum ada data enroll</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
