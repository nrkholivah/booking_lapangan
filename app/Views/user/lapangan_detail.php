<?= $this->extend('layout/user') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-8 offset-md-2">
        <div class="card shadow-sm mt-4">
            <div class="card-header bg-danger text-white">
                <h4 class="mb-0">Detail Lapangan: <?= esc($lapangan['name']) ?></h4>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <?php if ($lapangan['image']): ?> <img src="<?= base_url($lapangan['image']) ?>" class="img-fluid rounded mb-3" alt="<?= esc($lapangan['name']) ?>"> <?php else: ?>
                            <img src="https://placehold.co/600x400/FF0000/FFFFFF?text=No+Image" class="img-fluid rounded mb-3" alt="No Image">
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                        <p><strong>Deskripsi:</strong> <?= esc($lapangan['description']) ?></p>
                        <p><strong>Harga:</strong> Rp<?= number_format($lapangan['price_per_hour'], 0, ',', '.') ?> / jam</p>
<<<<<<< HEAD
                        <p><strong>Status:</strong>
                            <?php if ($lapangan['status'] == 'available'): ?> <span class="badge bg-success">Tersedia</span>
                            <?php elseif ($lapangan['status'] == 'maintenance'): ?> <span class="badge bg-warning text-dark">Perawatan</span>
                            <?php else: ?>
                                <span class="badge bg-danger">Tidak Tersedia</span>
                            <?php endif; ?>
                        </p>
=======
                        <p class="card-text">
                        <p><strong>Status:</strong>
                            <?php
                            $statusBadges = [
                                'Tersedia'   => ['class' => 'bg-success', 'label' => 'Tersedia'],
                                'Perawatan' => ['class' => 'bg-warning text-dark', 'label' => 'Perawatan'],
                                'Penuh' => ['class' => 'bg-danger', 'label' => 'Penuh']
                            ];
                            $status = $lapangan['status'];
                            $badge = $statusBadges[$status] ?? ['class' => 'bg-secondary', 'label' => ucfirst($status)];
                            ?>
                            <span class="badge <?= $badge['class'] ?>"><?= $badge['label'] ?></span>
                        </p>

>>>>>>> f15f568 (first commit)
                    </div>
                </div>

                <hr>

<<<<<<< HEAD
                <?php if ($lapangan['status'] == 'available'): ?> <h5>Booking Lapangan Ini</h5>
                    <?= form_open(base_url('booking/create')) ?>
                    <input type="hidden" name="lapangan_id" value="<?= esc($lapangan['id']) ?>">
                    <div class="mb-3">
                        <label for="booking_date" class="form-label">Tanggal Booking</label>
                        <input type="date" class="form-control" id="booking_date" name="booking_date" required min="<?= date('Y-m-d') ?>">
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="start_time" class="form-label">Jam Mulai</label>
                            <input type="time" class="form-control" id="start_time" name="start_time" required>
                        </div>
                        <div class="col-md-6">
                            <label for="end_time" class="form-label">Jam Selesai</label>
                            <input type="time" class="form-control" id="end_time" name="end_time" required>
                        </div>
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-danger">Booking Sekarang</button>
                    </div>
                    <?= form_close() ?>
                <?php else: ?>
                    <div class="alert alert-warning text-center" role="alert">
                        Lapangan ini sedang tidak tersedia untuk booking.
=======
                <?php if ($lapangan['status'] == 'Tersedia'): ?> <h5>Booking Lapangan Ini</h5>
                    <form action="<?= base_url('booking/create') ?>" method="post">
                        <?= csrf_field() ?>
                        <input type="hidden" name="lapangan_id" value="<?= esc($lapangan['id']) ?>">
                        <div class="mb-3">
                            <label for="booking_date" class="form-label">Tanggal Booking</label>
                            <input type="date" class="form-control" id="booking_date" name="booking_date" required min="<?= date('Y-m-d') ?>">
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="start_time" class="form-label">Jam Mulai</label>
                                <input type="time" class="form-control" id="start_time" name="start_time" required>
                            </div>
                            <div class="col-md-6">
                                <label for="end_time" class="form-label">Jam Selesai</label>
                                <input type="time" class="form-control" id="end_time" name="end_time" required>
                            </div>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-danger">Booking Sekarang</button>
                        </div>
                    </form>
                <?php else: ?>
                    <div class="alert alert-warning text-center" role="alert">
                        Lapangan ini sudah penuh untuk booking.
>>>>>>> f15f568 (first commit)
                    </div>
                <?php endif; ?>
            </div>
            <div class="card-footer text-center">
                <a href="<?= base_url('/') ?>" class="btn btn-secondary">Kembali ke Daftar Lapangan</a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>