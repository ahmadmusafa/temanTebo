<?= $this->extend('layouts/superadmin') ?>
<?= $this->section('content') ?>

<?php
    $baseUrl = site_url('superadmin/kritiksaran');

    $query = array_filter(
        ['jenis' => $jenis, 'q' => $q],
        static fn ($v) => $v !== ''
    );

    $urlHal = static fn (int $p): string =>
        $baseUrl . '?' . http_build_query($query + ['page' => $p]);
?>

<div class="container-fluid py-4">

    <!-- Header -->
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h4 class="fw-bold mb-1">Kritik &amp; Saran</h4>
            <p class="text-secondary mb-0 small">
                Kelola masukan dan tanggapan dari pengguna.
            </p>
        </div>

        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2">
                <i class="bi bi-chat-square-text me-1"></i>
                <?= esc($total) ?> Masukan
            </span>
        </div>
    </div>

    <!-- Flash Message -->
    <?php if ($s = session()->getFlashdata('ks_success')): ?>
        <div class="alert alert-success alert-dismissible fade show border-0 shadow-sm">
            <i class="bi bi-check-circle me-2"></i>
            <?= esc($s) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if ($e = session()->getFlashdata('ks_error')): ?>
        <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm">
            <i class="bi bi-exclamation-circle me-2"></i>
            <?= esc($e) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <!-- Main Card -->
    <div class="card border-0 shadow-sm rounded-3">

        <div class="card-body p-3 p-md-4">

            <!-- Filter -->
            <form method="get" action="<?= $baseUrl ?>" class="row g-2 mb-4">

                <div class="col-md-3">
                    <select name="jenis" class="form-select">
                        <option value="">Semua Jenis</option>
                        <option value="kritik" <?= $jenis === 'kritik' ? 'selected' : '' ?>>
                            Kritik
                        </option>
                        <option value="saran" <?= $jenis === 'saran' ? 'selected' : '' ?>>
                            Saran
                        </option>
                    </select>
                </div>

                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0">
                            <i class="bi bi-search text-secondary"></i>
                        </span>
                        <input
                            type="text"
                            name="q"
                            class="form-control border-start-0"
                            placeholder="Cari nama, email, atau pesan..."
                            value="<?= esc($q) ?>"
                        >
                    </div>
                </div>

                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary flex-fill">
                        <i class="bi bi-search me-1"></i> Cari
                    </button>

                    <?php if ($jenis !== '' || $q !== ''): ?>
                        <a href="<?= $baseUrl ?>" class="btn btn-light border">
                            <i class="bi bi-arrow-counterclockwise"></i>
                            Reset
                        </a>
                    <?php endif; ?>
                </div>

            </form>

            <!-- Table -->
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th class="text-secondary small fw-semibold py-3" style="width: 55px;">No</th>
                            <th class="text-secondary small fw-semibold py-3">PENGIRIM</th>
                            <th class="text-secondary small fw-semibold py-3" style="width: 110px;">JENIS</th>
                            <th class="text-secondary small fw-semibold py-3">PESAN</th>
                            <th class="text-secondary small fw-semibold py-3" style="width: 150px;">TANGGAL</th>
                            <th class="text-secondary small fw-semibold py-3 text-end" style="width: 80px;">AKSI</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php if (! empty($daftar)): ?>

                        <?php foreach ($daftar as $i => $row): ?>

                            <?php
                                $tanggal = ! empty($row['created_at'])
                                    ? date('d/m/Y H:i', strtotime($row['created_at']))
                                    : '-';

                                $isKritik = $row['jenis'] === 'kritik';

                                $badge = $isKritik
                                    ? 'bg-warning-subtle text-warning-emphasis'
                                    : 'bg-success-subtle text-success-emphasis';

                                $nomor = ($halaman - 1) * $perPage + $i + 1;
                            ?>

                            <tr>

                                <td class="text-secondary small">
                                    <?= $nomor ?>
                                </td>

                                <td>
                                    <div class="fw-semibold text-dark">
                                        <?= esc($row['nama']) ?>
                                    </div>
                                    <div class="small text-secondary">
                                        <?= esc($row['email'] ?: '-') ?>
                                    </div>
                                </td>

                                <td>
                                    <span class="badge <?= $badge ?> rounded-pill px-3 py-2">
                                        <?= esc(ucfirst($row['jenis'])) ?>
                                    </span>
                                </td>

                                <td>
                                    <span class="text-secondary">
                                        <?= esc(mb_strimwidth($row['pesan'], 0, 80, '...')) ?>
                                    </span>
                                </td>

                                <td class="small text-secondary">
                                    <?= esc($tanggal) ?>
                                </td>

                                <td class="text-end">
                                    <button
                                        type="button"
                                        class="btn btn-sm btn-light border text-danger"
                                        data-bs-toggle="modal"
                                        data-bs-target="#modalHapus"
                                        data-action="<?= site_url('superadmin/kritiksaran/hapus/' . $row['id']) ?>"
                                        data-nama="<?= esc($row['nama']) ?>"
                                    >
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </td>

                            </tr>

                        <?php endforeach; ?>

                    <?php else: ?>

                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <i class="bi bi-inbox display-5 text-secondary opacity-50"></i>
                                <p class="fw-semibold mt-3 mb-1">Belum ada masukan</p>
                                <p class="text-secondary small mb-0">
                                    Data kritik dan saran akan muncul di sini.
                                </p>
                            </td>
                        </tr>

                    <?php endif; ?>

                    </tbody>
                </table>
            </div>

            <!-- Footer & Pagination -->
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mt-4">

                <div class="text-secondary small">
                    Menampilkan <?= count($daftar) ?> dari <?= esc($total) ?> masukan
                </div>

                <?php if ($totalHalaman > 1): ?>

                    <nav aria-label="Navigasi halaman">
                        <ul class="pagination pagination-sm mb-0">

                            <li class="page-item <?= $halaman <= 1 ? 'disabled' : '' ?>">
                                <a class="page-link" href="<?= esc($urlHal(max(1, $halaman - 1))) ?>">
                                    <i class="bi bi-chevron-left"></i>
                                </a>
                            </li>

                            <?php for ($p = 1; $p <= $totalHalaman; $p++): ?>

                                <li class="page-item <?= $p === $halaman ? 'active' : '' ?>">
                                    <a class="page-link" href="<?= esc($urlHal($p)) ?>">
                                        <?= $p ?>
                                    </a>
                                </li>

                            <?php endfor; ?>

                            <li class="page-item <?= $halaman >= $totalHalaman ? 'disabled' : '' ?>">
                                <a class="page-link" href="<?= esc($urlHal(min($totalHalaman, $halaman + 1))) ?>">
                                    <i class="bi bi-chevron-right"></i>
                                </a>
                            </li>

                        </ul>
                    </nav>

                <?php endif; ?>

            </div>

        </div>
    </div>
</div>

<!-- Modal Hapus -->
<div class="modal fade" id="modalHapus" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content border-0 shadow">

            <form method="post" id="formHapus">
                <?= csrf_field() ?>

                <input type="hidden" name="jenis" value="<?= esc($jenis) ?>">
                <input type="hidden" name="q" value="<?= esc($q) ?>">
                <input type="hidden" name="page" value="<?= esc($halaman) ?>">

                <div class="modal-body text-center p-4">

                    <div class="mb-3">
                        <i class="bi bi-exclamation-circle text-danger display-4"></i>
                    </div>

                    <h5 class="fw-bold">Hapus Masukan?</h5>

                    <p class="text-secondary small mb-4">
                        Apakah Anda yakin ingin menghapus masukan dari
                        <strong id="namaPengirim"></strong>?
                        Tindakan ini tidak dapat dibatalkan.
                    </p>

                    <div class="d-flex gap-2">
                        <button
                            type="button"
                            class="btn btn-light border flex-fill"
                            data-bs-dismiss="modal"
                        >
                            Batal
                        </button>

                        <button type="submit" class="btn btn-danger flex-fill">
                            <i class="bi bi-trash me-1"></i> Hapus
                        </button>
                    </div>

                </div>
            </form>

        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modalHapus = document.getElementById('modalHapus');
        const formHapus = document.getElementById('formHapus');
        const namaPengirim = document.getElementById('namaPengirim');

        modalHapus.addEventListener('show.bs.modal', function (event) {
            const button = event.relatedTarget;

            formHapus.action = button.dataset.action;
            namaPengirim.textContent = button.dataset.nama;
        });
    });
</script>

<?= $this->endSection() ?>
