
<?= $this->extend('layouts/superadmin') ?>

<?= $this->section('content') ?>

<div class="page-wrapper">
    <div class="page-content">

        <!-- Page Header -->
        <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3">Superadmin</div>
            <div class="ps-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-0 p-0">
                        <li class="breadcrumb-item">
                            <a href="<?= base_url('superadmin') ?>">
                                <i class="bx bx-home-alt"></i>
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            Pendaftaran
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Title -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div>
                <h4 class="mb-1">Pendaftaran Peserta</h4>
                <p class="text-muted mb-0">
                    Kelola dan verifikasi pendaftaran peserta kegiatan.
                </p>
            </div>
        </div>

        <!-- Flash Message -->
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success alert-dismissible fade show">
                <?= esc(session()->getFlashdata('success')) ?>
                <button type="button" class="btn-close"
                    data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger alert-dismissible fade show">
                <?= esc(session()->getFlashdata('error')) ?>
                <button type="button" class="btn-close"
                    data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

        <!-- Statistics -->
        <div class="row row-cols-1 row-cols-md-2 row-cols-xl-4 g-3 mb-4">

            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-1 text-secondary">Total Pendaftaran</p>
                                <h4 class="mb-0"><?= $total ?></h4>
                            </div>
                            <div class="ms-auto">
                                <i class="bx bx-group fs-2 text-primary"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-1 text-secondary">Menunggu Verifikasi</p>
                                <h4 class="mb-0"><?= $menunggu ?></h4>
                            </div>
                            <div class="ms-auto">
                                <i class="bx bx-time-five fs-2 text-warning"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-1 text-secondary">Diterima</p>
                                <h4 class="mb-0"><?= $diterima ?></h4>
                            </div>
                            <div class="ms-auto">
                                <i class="bx bx-check-circle fs-2 text-success"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col">
                <div class="card radius-10">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div>
                                <p class="mb-1 text-secondary">Ditolak</p>
                                <h4 class="mb-0"><?= $ditolak ?></h4>
                            </div>
                            <div class="ms-auto">
                                <i class="bx bx-x-circle fs-2 text-danger"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Table -->
        <div class="card radius-10">
            <div class="card-header bg-white">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                    <h5 class="mb-0">Data Pendaftaran</h5>

                    <div class="d-flex gap-2">
                        <select id="filterStatus"
                            class="form-select form-select-sm">
                            <option value="">Semua Status</option>
                            <option value="menunggu_verifikasi">Menunggu Verifikasi</option>
                            <option value="diterima">Diterima</option>
                            <option value="ditolak">Ditolak</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table id="tabelPendaftaran"
                        class="table table-hover align-middle">

                        <thead class="table-light">
                            <tr>
                                <th>No.</th>
                                <th>Kode Pendaftaran</th>
                                <th>Peserta</th>
                                <th>Kegiatan</th>
                                <th>Pembayaran</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php foreach ($pendaftaran as $index => $item): ?>

                                <?php
                                    $status = $item['status_pendaftaran'];

                                    $badge = match ($status) {
                                        'menunggu_verifikasi' => 'bg-warning text-dark',
                                        'diterima' => 'bg-success',
                                        'ditolak' => 'bg-danger',
                                        default => 'bg-secondary',
                                    };

                                    $label = match ($status) {
                                        'menunggu_verifikasi' => 'Menunggu Verifikasi',
                                        'diterima' => 'Diterima',
                                        'ditolak' => 'Ditolak',
                                        default => ucfirst($status),
                                    };
                                ?>

                                <tr>
                                    <td><?= $index + 1 ?></td>

                                    <td>
                                        <span class="fw-semibold">
                                            <?= esc($item['kode_pendaftaran']) ?>
                                        </span>
                                    </td>

                                    <td>
                                        <div class="fw-semibold">
                                            <?= esc($item['nama_lengkap']) ?>
                                        </div>
                                        <small class="text-muted">
                                            <?= esc($item['email']) ?>
                                        </small>
                                    </td>

                                    <td>
                                        <?= esc($item['nama_kegiatan']) ?>
                                    </td>

                                    <td>
                                        Rp <?= number_format(
                                            (float) $item['jumlah_pembayaran'],
                                            0,
                                            ',',
                                            '.'
                                        ) ?>
                                    </td>

                                    <td>
                                        <span class="badge <?= $badge ?>">
                                            <?= esc($label) ?>
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <button type="button"
                                            class="btn btn-sm btn-outline-primary"
                                            data-bs-toggle="modal"
                                            data-bs-target="#detail<?= $item['id_pendaftaran'] ?>">
                                            <i class="bx bx-show"></i>
                                            Detail
                                        </button>
                                    </td>
                                </tr>

                            <?php endforeach; ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>

    </div>
</div>

<!-- Detail & Verifikasi Modal -->
<?php foreach ($pendaftaran as $item): ?>

    <?php
        $id = $item['id_pendaftaran'];
        $status = $item['status_pendaftaran'];
    ?>

    <div class="modal fade" id="detail<?= $id ?>" tabindex="-1"
        aria-hidden="true">

        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Detail Pendaftaran</h5>
                    <button type="button" class="btn-close"
                        data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div>
                            <small class="text-muted">Kode Pendaftaran</small>
                            <h6 class="mb-0">
                                <?= esc($item['kode_pendaftaran']) ?>
                            </h6>
                        </div>

                        <span class="badge <?= match ($status) {
                            'menunggu_verifikasi' => 'bg-warning text-dark',
                            'diterima' => 'bg-success',
                            'ditolak' => 'bg-danger',
                            default => 'bg-secondary',
                        } ?>">
                            <?= esc(match ($status) {
                                'menunggu_verifikasi' => 'Menunggu Verifikasi',
                                'diterima' => 'Diterima',
                                'ditolak' => 'Ditolak',
                                default => ucfirst($status),
                            }) ?>
                        </span>
                    </div>

                    <hr>

                    <h6 class="mb-3">Informasi Peserta</h6>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <small class="text-muted">Nama Lengkap</small>
                            <div class="fw-semibold">
                                <?= esc($item['nama_lengkap']) ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted">Nama Panggilan</small>
                            <div class="fw-semibold">
                                <?= esc($item['nama_panggilan']) ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted">Email</small>
                            <div><?= esc($item['email']) ?></div>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted">WhatsApp</small>
                            <div><?= esc($item['no_whatsapp']) ?></div>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted">Jenis Kelamin</small>
                            <div><?= esc($item['jenis_kelamin']) ?></div>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted">Tanggal Lahir</small>
                            <div><?= esc($item['tanggal_lahir']) ?></div>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted">Domisili</small>
                            <div><?= esc($item['domisili']) ?></div>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted">Instansi</small>
                            <div><?= esc($item['instansi'] ?: '-') ?></div>
                        </div>
                    </div>

                    <hr>

                    <h6 class="mb-3">Informasi Kegiatan</h6>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <small class="text-muted">Nama Kegiatan</small>
                            <div class="fw-semibold">
                                <?= esc($item['nama_kegiatan']) ?>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted">Tanggal Kegiatan</small>
                            <div><?= esc($item['tanggal_kegiatan']) ?></div>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted">Jenis Biaya</small>
                            <div><?= esc(ucfirst($item['jenis_biaya'])) ?></div>
                        </div>

                        <div class="col-md-6">
                            <small class="text-muted">Jumlah Pembayaran</small>
                            <div class="fw-semibold">
                                Rp <?= number_format(
                                    (float) $item['jumlah_pembayaran'],
                                    0,
                                    ',',
                                    '.'
                                ) ?>
                            </div>
                        </div>
                    </div>

                    <!-- Bukti Pembayaran -->
                    <?php if ($item['jenis_biaya'] === 'berbayar'): ?>
                        <hr>

                        <h6 class="mb-3">Bukti Pembayaran</h6>

                        <?php if (!empty($item['bukti_pembayaran'])): ?>

                            <?php
                                $file = basename($item['bukti_pembayaran']);
                                $ekstensi = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                $urlBukti = base_url('superadmin/pendaftaran/bukti/' . $id);
                            ?>

                            <div class="border rounded-3 p-3">

                                <p class="text-muted small mb-3">
                                    Nama file: <?= esc($file) ?>
                                </p>

                                <?php if (in_array($ekstensi, ['jpg', 'jpeg', 'png'], true)): ?>

                                    <a href="<?= esc($urlBukti) ?>" target="_blank">
                                        <img
                                            src="<?= esc($urlBukti) ?>"
                                            alt="Bukti Pembayaran"
                                            class="img-fluid rounded border"
                                            style="max-height: 400px; width: auto;">
                                    </a>

                                <?php elseif ($ekstensi === 'pdf'): ?>

                                    <iframe
                                        src="<?= esc($urlBukti) ?>"
                                        width="100%"
                                        height="450"
                                        class="border rounded">
                                    </iframe>

                                <?php else: ?>

                                    <div class="alert alert-warning mb-0">
                                        Format bukti pembayaran tidak didukung.
                                    </div>

                                <?php endif; ?>

                                <a href="<?= esc($urlBukti) ?>"
                                    target="_blank"
                                    class="btn btn-sm btn-outline-primary mt-3">
                                    <i class="bx bx-file"></i>
                                    Buka Bukti Pembayaran
                                </a>

                            </div>

                        <?php else: ?>

                            <div class="alert alert-warning">
                                Bukti pembayaran belum tersedia.
                            </div>

                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if ($status === 'ditolak' && !empty($item['catatan_admin'])): ?>
                        <hr>
                        <h6>Catatan Admin</h6>
                        <div class="alert alert-light border">
                            <?= nl2br(esc($item['catatan_admin'])) ?>
                        </div>
                    <?php endif; ?>

                </div>

                <?php if ($status === 'menunggu_verifikasi'): ?>

                    <div class="modal-footer">

                        <button type="button"
                            class="btn btn-light"
                            data-bs-dismiss="modal">
                            Tutup
                        </button>

                        <button type="button"
                            class="btn btn-danger"
                            data-bs-toggle="modal"
                            data-bs-target="#tolak<?= $id ?>">
                            Tolak
                        </button>

                        <form action="<?= base_url('superadmin/pendaftaran/setujui/' . $id) ?>"
                            method="post">
                            <?= csrf_field() ?>

                            <button type="submit"
                                class="btn btn-success"
                                onclick="return confirm('Yakin ingin menyetujui pendaftaran ini?')">
                                <i class="bx bx-check"></i>
                                Setujui Pendaftaran
                            </button>
                        </form>

                    </div>

                <?php endif; ?>

            </div>
        </div>
    </div>

    <!-- Modal Tolak -->
    <?php if ($status === 'menunggu_verifikasi'): ?>

        <div class="modal fade" id="tolak<?= $id ?>" tabindex="-1"
            aria-hidden="true">

            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <form action="<?= base_url('superadmin/pendaftaran/tolak/' . $id) ?>"
                        method="post">

                        <?= csrf_field() ?>

                        <div class="modal-header">
                            <h5 class="modal-title">Tolak Pendaftaran</h5>
                            <button type="button" class="btn-close"
                                data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <p>
                                Apakah kamu yakin ingin menolak pendaftaran
                                <strong><?= esc($item['nama_lengkap']) ?></strong>?
                            </p>

                            <label class="form-label">
                                Catatan Admin
                            </label>

                            <textarea name="catatan_admin"
                                class="form-control"
                                rows="3"
                                placeholder="Tuliskan alasan penolakan..."
                                required></textarea>
                        </div>

                        <div class="modal-footer">
                            <button type="button"
                                class="btn btn-light"
                                data-bs-dismiss="modal">
                                Batal
                            </button>

                            <button type="submit"
                                class="btn btn-danger">
                                Tolak Pendaftaran
                            </button>
                        </div>

                    </form>

                </div>
            </div>
        </div>

    <?php endif; ?>

<?php endforeach; ?>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const filter = document.getElementById('filterStatus');
        const table = document.getElementById('tabelPendaftaran');

        if (!filter || !table) return;

        filter.addEventListener('change', function () {
            const selected = this.value;

            table.querySelectorAll('tbody tr').forEach(function (row) {
                const badge = row.querySelector('td:nth-child(6) .badge');
                const status = badge ? badge.textContent.trim() : '';

                const cocok = selected === ''
                    || (selected === 'menunggu_verifikasi' && status === 'Menunggu Verifikasi')
                    || (selected === 'diterima' && status === 'Diterima')
                    || (selected === 'ditolak' && status === 'Ditolak');

                row.style.display = cocok ? '' : 'none';
            });
        });
    });
</script>

<?= $this->endSection() ?>
