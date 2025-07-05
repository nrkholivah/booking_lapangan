<div class="list-group shadow-sm">
    <a href="<?= base_url('admin') ?>" class="list-group-item list-group-item-action <?= (current_url() == base_url('admin')) ? 'active bg-danger text-white' : '' ?>">
        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
    </a>
    <a href="<?= base_url('admin/fields') ?>" class="list-group-item list-group-item-action <?= (strpos(current_url(), 'admin/fields') !== false) ? 'active bg-danger text-white' : '' ?>">
        <i class="fas fa-futbol me-2"></i> Manajemen Lapangan
    </a>
    <a href="<?= base_url('admin/bookings') ?>" class="list-group-item list-group-item-action <?= (strpos(current_url(), 'admin/bookings') !== false) ? 'active bg-danger text-white' : '' ?>">
        <i class="fas fa-calendar-alt me-2"></i> Manajemen Booking
    </a>
    <a href="<?= base_url('admin/reports') ?>" class="list-group-item list-group-item-action <?= (strpos(current_url(), 'admin/reports') !== false) ? 'active bg-danger text-white' : '' ?>">
        <i class="fas fa-chart-bar me-2"></i> Laporan & Grafik
    </a>
</div>