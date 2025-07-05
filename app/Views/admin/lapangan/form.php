<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-3">
        <?= $this->include('admin/sidebar') ?>
    </div>
    <div class="col-md-9">
        <h1 class="mb-4"><?= esc($title) ?></h1>

        <div class="card shadow-sm">
            <div class="card-body">
                <?= form_open_multipart(isset($field) ? base_url('admin/fields/update/' . $field['id']) : base_url('admin/fields/store')) ?>
                <div class="mb-3">
                    <label for="name" class="form-label">Nama Lapangan</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?= old('name', $field['name'] ?? '') ?>" required>
                </div>
                <div class="mb-3">
                    <label for="description" class="form-label">Deskripsi</label>
                    <textarea class="form-control" id="description" name="description" rows="3"><?= old('description', $field['description'] ?? '') ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="price_per_hour" class="form-label">Harga per Jam</label>
                    <input type="number" step="0.01" class="form-control" id="price_per_hour" name="price_per_hour" value="<?= old('price_per_hour', $field['price_per_hour'] ?? '') ?>" required>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Gambar Lapangan</label>
                    <input class="form-control" type="file" id="image" name="image" accept=".jpg, .jpeg, .png">
                    <?php if (isset($field) && $field['image']): ?>
                        <small class="form-text text-muted">Gambar saat ini: <a href="<?= base_url($field['image']) ?>" target="_blank">Lihat Gambar</a></small>
                    <?php endif; ?>
                </div>
                <div class="mb-3">
                    <label for="status" class="form-label">Status</label>
                    <select class="form-select" id="status" name="status" required>
                        <option value="available" <?= (isset($field) && $field['status'] == 'available') ? 'selected' : '' ?>>Tersedia</option>
                        <option value="maintenance" <?= (isset($field) && $field['status'] == 'maintenance') ? 'selected' : '' ?>>Perawatan</option>
                        <option value="unavailable" <?= (isset($field) && $field['status'] == 'unavailable') ? 'selected' : '' ?>>Tidak Tersedia</option>
                    </select>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-danger">Simpan</button>
                    <a href="<?= base_url('admin/fields') ?>" class="btn btn-secondary">Batal</a>
                </div>
                <?= form_close() ?>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>