<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-3">
        <?= $this->include('admin/sidebar') ?>
    </div>
    <div class="col-md-9">
        <h1 class="mb-4">Laporan & Grafik</h1>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">Grafik Penggunaan Lapangan</h5>
            </div>
            <div class="card-body">
                <canvas id="fieldUsageChart"></canvas>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">Laporan Semua Booking</h5>
            </div>
            <div class="card-body">
                <?php if (empty($all_bookings)): ?>
                    <p class="text-center">Belum ada data booking untuk laporan.</p>
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
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($all_bookings as $booking): ?>
                                    <tr>
                                        <td><?= esc($booking['id']) ?></td>
                                        <td><?= esc($booking['username']) ?></td>
                                        <td><?= esc($booking['field_name']) ?></td>
                                        <td><?= esc(date('d M Y', strtotime($booking['booking_date']))) ?></td>
                                        <td><?= esc(date('H:i', strtotime($booking['start_time']))) ?> - <?= esc(date('H:i', strtotime($booking['end_time']))) ?></td>
                                        <td>Rp<?= number_format($booking['total_price'], 0, ',', '.') ?></td>
                                        <td><span class="badge bg-<?= ($booking['payment_status'] == 'approved') ? 'success' : (($booking['payment_status'] == 'pending') ? 'warning text-dark' : 'danger') ?>"><?= esc(ucfirst($booking['payment_status'])) ?></span></td>
                                        <td><span class="badge bg-<?= ($booking['booking_status'] == 'approved') ? 'success' : (($booking['booking_status'] == 'pending') ? 'secondary' : 'danger') ?>"><?= esc(ucfirst($booking['booking_status'])) ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const fieldNames = <?= $field_names ?>;
        const bookingCounts = <?= $booking_counts ?>;

        const ctx = document.getElementById('fieldUsageChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar', // Bisa diganti 'line', 'pie', dll.
            data: {
                labels: fieldNames,
                datasets: [{
                    label: 'Jumlah Booking',
                    data: bookingCounts,
                    backgroundColor: 'rgba(220, 53, 69, 0.7)', // Warna merah
                    borderColor: 'rgba(220, 53, 69, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Jumlah Booking'
                        }
                    },
                    x: {
                        title: {
                            display: true,
                            text: 'Nama Lapangan'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: false
                    },
                    title: {
                        display: true,
                        text: 'Grafik Jumlah Booking per Lapangan'
                    }
                }
            }
        });
    });
</script>
<?= $this->endSection() ?>