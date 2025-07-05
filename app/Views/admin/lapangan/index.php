<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-3">
        <?= $this->include('admin/sidebar') ?>
    </div>
    <div class="col-md-9">
        <h1 class="mb-4">Manajemen Lapangan</h1>

        <div class="d-flex justify-content-end mb-3">
            <a href="<?= base_url('admin/lapangan/create') ?>" class="btn btn-danger"><i class="fas fa-plus me-2"></i> Tambah Lapangan</a>
        </div>

        <?php if (empty($lapangans)): ?>
            <div class="alert alert-info text-center" role="alert">
                Belum ada lapangan yang terdaftar.
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="table-danger text-white">
                        <tr>
                            <th>ID</th>
                            <th>Nama Lapangan</th>
                            <th>Harga/Jam</th>
                            <th>Status</th>
                            <th>Gambar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($lapangans as $lapangan): ?>
                            <tr>
                                <td><?= esc($lapangan['id']) ?></td>
                                <td><?= esc($lapangan['name']) ?></td>
                                <td>Rp<?= number_format($lapangan['price_per_hour'], 0, ',', '.') ?></td>
                                <td>
                                    <?php if ($lapangan['status'] == 'available'): ?>
                                        <span class="badge bg-success">Tersedia</span>
                                    <?php elseif ($lapangan['status'] == 'maintenance'): ?>
                                        <span class="badge bg-warning text-dark">Perawatan</span>
                                    <?php else: ?>
                                        <span class="badge bg-danger">Tidak Tersedia</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php if ($lapangan['image']): ?>
                                        <img src="<?= base_url($lapangan['image']) ?>" alt="Gambar Lapangan" style="width: 80px; height: 50px; object-fit: cover; border-radius: 5px;">
                                    <?php else: ?>
                                        Tidak ada
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <a href="<?= base_url('admin/lapangan/edit/' . $lapangan['id']) ?>" class="btn btn-sm btn-warning text-dark"><i class="fas fa-edit"></i> Edit</a>
                                    <a href="<?= base_url('admin/lapangan/delete/' . $lapangan['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus lapangan ini?');"><i class="fas fa-trash-alt"></i> Hapus</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
<?= $this->endSection() ?>