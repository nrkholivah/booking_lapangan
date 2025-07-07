<!-- app/Views/admin/bookings/detail.php -->
<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-3">
        <?= $this->include('admin/sidebar') ?>
    </div>
    <div class="col-md-9">
        <h1 class="mb-4">Detail Booking #<?= esc($booking['id']) ?></h1>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">Informasi Booking</h5>
            </div>
            <div class="card-body">
                <dl class="row">
                    <dt class="col-sm-3">Pengguna:</dt>
                    <!-- Perubahan di baris ini: menampilkan username dan no_hp -->
                    <dd class="col-sm-9"><?= esc($booking['username']) ?> (<?= esc($booking['no_hp']) ?>)</dd>

                    <dt class="col-sm-3">Lapangan:</dt>
                    <dd class="col-sm-9"><?= esc($booking['lapangan_name']) ?></dd>

                    <dt class="col-sm-3">Tanggal Booking:</dt>
                    <dd class="col-sm-9"><?= esc(date('d M Y', strtotime($booking['booking_date']))) ?></dd>

                    <dt class="col-sm-3">Waktu Booking:</dt>
                    <dd class="col-sm-9"><?= esc(date('H:i', strtotime($booking['start_time']))) ?> - <?= esc(date('H:i', strtotime($booking['end_time']))) ?></dd>

                    <dt class="col-sm-3">Harga per Jam:</dt>
                    <dd class="col-sm-9">Rp<?= number_format($booking['price_per_hour'], 0, ',', '.') ?></dd>

                    <dt class="col-sm-3">Total Harga:</dt>
                    <dd class="col-sm-9"><strong>Rp<?= number_format($booking['total_price'], 0, ',', '.') ?></strong></dd>

                    <dt class="col-sm-3">Status Pembayaran:</dt>
                    <dd class="col-sm-9">
                        <?php
                        $paymentStatusClass = '';
                        switch ($booking['payment_status']) {
                            case 'pending':
                                $paymentStatusClass = 'badge bg-warning text-dark';
                                break;
                            case 'paid':
                                $paymentStatusClass = 'badge bg-info text-dark';
                                break;
                            case 'approved':
                                $paymentStatusClass = 'badge bg-success';
                                break;
                            case 'rejected':
                                $paymentStatusClass = 'badge bg-danger';
                                break;
                        }
                        ?>
                        <span class="<?= $paymentStatusClass ?>"><?= esc(ucfirst($booking['payment_status'])) ?></span>
                    </dd>

                    <dt class="col-sm-3">Status Booking:</dt>
                    <dd class="col-sm-9">
                        <?php
                        $bookingStatusClass = '';
                        switch ($booking['booking_status']) {
                            case 'pending':
                                $bookingStatusClass = 'badge bg-secondary';
                                break;
                            case 'approved':
                                $bookingStatusClass = 'badge bg-success';
                                break;
                            case 'rejected':
                                $bookingStatusClass = 'badge bg-danger';
                                break;
                            case 'completed':
                                $bookingStatusClass = 'badge bg-primary';
                                break;
                            case 'cancelled':
                                $bookingStatusClass = 'badge bg-dark';
                                break;
                        }
                        ?>
                        <span class="<?= $bookingStatusClass ?>"><?= esc(ucfirst($booking['booking_status'])) ?></span>
                    </dd>

                    <dt class="col-sm-3">Dibuat Pada:</dt>
                    <dd class="col-sm-9"><?= esc(date('d M Y H:i', strtotime($booking['created_at']))) ?></dd>

                    <dt class="col-sm-3">Terakhir Diperbarui:</dt>
                    <dd class="col-sm-9"><?= esc(date('d M Y H:i', strtotime($booking['updated_at']))) ?></dd>
                </dl>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">Bukti Pembayaran</h5>
            </div>
            <div class="card-body text-center">
                <?php if ($booking['payment_proof']): ?>
                    <img src="<?= base_url($booking['payment_proof']) ?>" class="img-fluid rounded" alt="Bukti Pembayaran" style="max-height: 400px;">
                    <p class="mt-3"><a href="<?= base_url($booking['payment_proof']) ?>" target="_blank" class="btn btn-outline-primary">Lihat Gambar Ukuran Penuh</a></p>
                <?php else: ?>
                    <p class="text-muted">Belum ada bukti pembayaran diunggah.</p>
                <?php endif; ?>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">Aksi Admin</h5>
            </div>
            <div class="card-body">
                <?php if ($booking['booking_status'] != 'cancelled' && $booking['booking_status'] != 'completed'): ?>
                    <p><strong>Batalkan Booking:</strong></p>
                    <?= form_open(base_url('admin/bookings/cancel-booking/' . $booking['id'])) ?>
                    <div class="mb-3">
                        <textarea name="admin_notes" class="form-control" rows="3" placeholder="Alasan pembatalan (opsional)"><?= esc($booking['admin_notes'] ?? '') ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-secondary" onclick="return confirm('Apakah Anda yakin ingin membatalkan booking ini? Ini juga akan menolak pembayaran terkait.');"><i class="fas fa-ban"></i> Batalkan Booking</button>
                    <?= form_close() ?>
                <?php else: ?>
                    <p class="text-muted">Tidak ada aksi yang tersedia untuk booking ini karena statusnya sudah <?= esc(ucfirst($booking['booking_status'])) ?>.</p>
                <?php endif; ?>
            </div>
        </div>

        <a href="<?= base_url('admin/bookings') ?>" class="btn btn-outline-secondary">Kembali ke Daftar Booking</a>
    </div>
</div>
<?= $this->endSection() ?>