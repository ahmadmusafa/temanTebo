
<?= $this->extend('layouts/superadmin') ?>

<?= $this->section('content') ?>

<div class="mb-4">
    <h3 class="fw-bold mb-1">Kelola Statistik</h3>
    <p class="text-secondary mb-0">
        Atur angka statistik yang ditampilkan pada halaman utama TemanTebo.
    </p>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success">
        <?= esc(session()->getFlashdata('success')) ?>
    </div>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
    <div class="alert alert-danger">
        <?= esc(session()->getFlashdata('error')) ?>
    </div>
<?php endif; ?>

<?php $errors = session()->getFlashdata('errors') ?? []; ?>

<?php if (! empty($errors)): ?>
    <div class="alert alert-danger">
        <ul class="mb-0">
            <?php foreach ($errors as $error): ?>
                <li><?= esc($error) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<div class="card stat-card">
    <div class="card-body p-4">

        <form action="<?= site_url('superadmin/statistik/update') ?>" method="post">
            <?= csrf_field() ?>

            <div class="mb-3">
                <label for="relawan" class="form-label fw-semibold">
                    Total Relawan
                </label>
                <input
                    type="number"
                    class="form-control"
                    id="relawan"
                    name="relawan"
                    min="0"
                    value="<?= esc(old('relawan') ?? $statistik['relawan']) ?>"
                    required
                >
            </div>

            <div class="mb-3">
                <label for="organisasi" class="form-label fw-semibold">
                    Total Organisasi
                </label>
                <input
                    type="number"
                    class="form-control"
                    id="organisasi"
                    name="organisasi"
                    min="0"
                    value="<?= esc(old('organisasi') ?? $statistik['organisasi']) ?>"
                    required
                >
            </div>

            <div class="mb-4">
                <label for="aktivitas_sosial" class="form-label fw-semibold">
                    Total Aktivitas Sosial
                </label>
                <input
                    type="number"
                    class="form-control"
                    id="aktivitas_sosial"
                    name="aktivitas_sosial"
                    min="0"
                    value="<?= esc(old('aktivitas_sosial') ?? $statistik['aktivitas_sosial']) ?>"
                    required
                >
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save me-1"></i>
                Simpan Perubahan
            </button>

            <a href="<?= site_url('superadmin') ?>" class="btn btn-light">
                Kembali
            </a>
        </form>

    </div>
</div>

<?= $this->endSection() ?>
