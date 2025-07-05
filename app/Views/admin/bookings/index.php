<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-3">
        <?= $this->include('admin/sidebar') ?>
    </div>
    <div class="col-md-9">
        <h1 class="mb-4">Manajemen Booking</h1>

        <?php if (empty($bookings)): ?>
            <div class="alert alert-info text-center" role="alert">
                Belum ada booking yang terdaftar.
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover table-bordered">
                    <thead class="table-danger text-white">
                        <tr>
                            <th>ID</th>
                            <th>Pengguna</th>
                            <th>Lapangan</th>
                            <th>Tanggal</th>
                            <th>Waktu</th>
                            <th>Total Harga</th>
                            <th>Pembayaran</th>
                            <th>Status Booking</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $booking): ?>
                            <tr>
                                <td><?= esc($booking['id']) ?></td>
                                <td><?= esc($booking['username']) ?></td>
                                <td><?= esc($booking['field_name']) ?></td>
                                <td><?= esc(date('d M Y', strtotime($booking['booking_date']))) ?></td>
                                <td><?= esc(date('H:i', strtotime($booking['start_time']))) ?> - <?= esc(date('H:i', strtotime($booking['end_time']))) ?></td>
                                <td>Rp<?= number_format($booking['total_price'], 0, ',', '.') ?></td>
                                <td>
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
                                </td>
                                <td>
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
                                </td>
                                <td>
                                    <a href="<?= base_url('admin/bookings/detail/' . $booking['id']) ?>" class="btn btn-sm btn-outline-primary">Detail</a>
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