<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<h1 class="mb-4">Daftar Lapangan Tersedia</h1>

<div class="row">
    <?php if (empty($fields)): ?>
        <div class="col-12">
            <div class="alert alert-info" role="alert">
                Belum ada lapangan yang terdaftar.
            </div>
        </div>
    <?php else: ?>
        <?php foreach ($fields as $field): ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm h-100">
                    <?php if ($field['image']): ?>
                        <img src="<?= base_url($field['image']) ?>" class="card-img-top" alt="<?= esc($field['name']) ?>" style="height: 200px; object-fit: cover;">
                    <?php else: ?>
                        <img src="[https://placehold.co/600x400/FF0000/FFFFFF?text=No+Image](https://placehold.co/600x400/FF0000/FFFFFF?text=No+Image)" class="card-img-top" alt="No Image" style="height: 200px; object-fit: cover;">
                    <?php endif; ?>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?= esc($field['name']) ?></h5>
                        <p class="card-text text-muted small"><?= esc(word_limiter($field['description'] ?? 'Tidak ada deskripsi.', 20)) ?></p>
                        <p class="card-text">
                            <strong>Harga:</strong> Rp<?= number_format($field['price_per_hour'], 0, ',', '.') ?> / jam
                        </p>
                        <p class="card-text">
                            <strong>Status:</strong>
                            <?php if ($field['status'] == 'available'): ?>
                                <span class="badge bg-success">Tersedia</span>
                            <?php elseif ($field['status'] == 'maintenance'): ?>
                                <span class="badge bg-warning text-dark">Perawatan</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Tidak Tersedia</span>
                            <?php endif; ?>
                        </p>
                        <div class="mt-auto">
                            <a href="<?= base_url('field/' . $field['id']) ?>" class="btn btn-danger w-100">Lihat Detail & Booking</a>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>