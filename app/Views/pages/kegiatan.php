
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<link rel="stylesheet" href="<?= base_url('assets/css/kegiatan.css') ?>">

<div class="container py-5">

    <div class="text-center mb-5">
        <h2 class="fw-bold">Kegiatan Relawan</h2>
        <p class="text-secondary">
            Temukan kegiatan menarik dan jadilah bagian dari perubahan.
        </p>
    </div>

    <div class="row g-4">

        <?php if (empty($kegiatan)): ?>
            <div class="col-12 text-center py-5">
                <i class="bi bi-calendar-x fs-1 text-secondary"></i>
                <p class="text-secondary mt-3">Belum ada kegiatan tersedia.</p>
            </div>
        <?php endif; ?>

        <?php foreach ($kegiatan as $event): ?>

            <?php
            $dibuka = ($event['status_pendaftaran'] ?? '') === 'dibuka';
            $lokasi = $event['lokasi'] ?? '';
            $jam    = ($event['jam'] ?? '') ?: '-';

            $maps = 'https://www.google.com/maps/search/?api=1&query='
                . rawurlencode($lokasi);

            $gambar = ! empty($event['gambar'])
                ? site_url('kegiatan/gambar/' . rawurlencode($event['gambar']))
                : '';

            $biaya = ($event['jenis_biaya'] ?? '') === 'gratis'
                ? 'Gratis'
                : 'Rp ' . number_format(
                    (float) ($event['biaya_pendaftaran'] ?? 0),
                    0,
                    ',',
                    '.'
                );
            ?>

            <div class="col-md-6 col-lg-4">

                <div
                    class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden event-card"
                    role="button"
                    tabindex="0"
                    data-id="<?= esc($event['id'], 'attr') ?>"
                    data-judul="<?= esc($event['judul'], 'attr') ?>"
                    data-kategori="<?= esc($event['kategori'] ?? '', 'attr') ?>"
                    data-deskripsi="<?= esc($event['deskripsi'] ?? '', 'attr') ?>"
                    data-tanggal="<?= esc($event['tanggal'] ?? '', 'attr') ?>"
                    data-jam="<?= esc($jam, 'attr') ?>"
                    data-lokasi="<?= esc($lokasi, 'attr') ?>"
                    data-kuota="<?= esc($event['kuota'] ?? 0, 'attr') ?>"
                    data-biaya="<?= esc($biaya, 'attr') ?>"
                    data-jenis-biaya="<?= esc($event['jenis_biaya'] ?? '', 'attr') ?>"
                    data-nominal="<?= esc($event['biaya_pendaftaran'] ?? 0, 'attr') ?>"
                    data-gambar="<?= esc($gambar, 'attr') ?>"
                    data-maps="<?= esc($maps, 'attr') ?>"
                    data-dibuka="<?= $dibuka ? '1' : '0' ?>"
                >

                    <?php if ($gambar): ?>
                        <img
                            src="<?= esc($gambar, 'attr') ?>"
                            class="card-img-top event-img"
                            alt="<?= esc($event['judul'], 'attr') ?>"
                        >
                    <?php else: ?>
                        <div class="event-img bg-light d-flex align-items-center justify-content-center">
                            <i class="bi bi-image fs-1 text-secondary"></i>
                        </div>
                    <?php endif; ?>

                    <div class="card-body d-flex flex-column">

                        <div class="d-flex justify-content-between gap-2 mb-2">
                            <h5 class="fw-bold mb-0">
                                <?= esc($event['judul']) ?>
                            </h5>

                            <span class="badge <?= $dibuka ? 'text-bg-success' : 'text-bg-secondary' ?>">
                                <?= $dibuka ? 'Tersedia' : 'Di Tutup' ?>
                            </span>
                        </div>

                        <p class="text-secondary small text-truncate mb-3">
                            <?= esc($event['deskripsi'] ?? '') ?>
                        </p>

                        <div class="small mb-3">
                            <i class="bi bi-geo-alt text-brand me-2"></i>

                            <a
                                href="<?= esc($maps, 'attr') ?>"
                                target="_blank"
                                rel="noopener noreferrer"
                                class="text-decoration-none text-secondary"
                            >
                                <?= esc($lokasi ?: 'Lihat lokasi') ?>
                            </a>
                        </div>

                        <hr class="mt-auto">

                        <div class="d-flex justify-content-end gap-2">

                            <button type="button" class="btn btn-sm btn-outline-brand btn-detail">
                                Detail
                            </button>

                            <button
                                type="button"
                                class="btn btn-sm btn-brand btn-daftar"
                                <?= $dibuka ? '' : 'disabled' ?>
                            >
                                Daftar
                            </button>

                        </div>

                    </div>
                </div>
            </div>

        <?php endforeach; ?>

    </div>
</div>

<!-- MODAL DETAIL -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 border-0">

            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="detailJudul"></h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <img
                    id="detailGambar"
                    class="img-fluid rounded-3 w-100 mb-3"
                    style="max-height: 300px; object-fit: cover;"
                    alt="Foto kegiatan"
                >

                <div class="d-flex justify-content-between mb-3">
                    <span class="badge bg-brand text-white" id="detailKategori"></span>
                    <span class="badge" id="detailStatus"></span>
                </div>

                <p class="text-secondary" id="detailDeskripsi"></p>

                <hr>

                <div class="row g-3">

                    <div class="col-md-6">
                        <i class="bi bi-calendar-event text-brand me-2"></i>
                        <span id="detailTanggal"></span>
                    </div>

                    <div class="col-md-6">
                        <i class="bi bi-clock text-brand me-2"></i>
                        <span id="detailJam"></span>
                    </div>

                    <div class="col-md-6">
                        <i class="bi bi-geo-alt text-brand me-2"></i>
                        <span id="detailLokasi"></span>
                    </div>

                    <div class="col-md-6">
                        <i class="bi bi-people text-brand me-2"></i>
                        Kuota: <span id="detailKuota"></span>
                    </div>

                    <div class="col-12">
                        <i class="bi bi-cash text-brand me-2"></i>
                        <span class="fw-bold" id="detailBiaya"></span>
                    </div>

                </div>

                <a
                    href="#"
                    id="detailMaps"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="btn btn-outline-secondary btn-sm mt-3"
                >
                    <i class="bi bi-map me-1"></i>
                    Lihat Google Maps
                </a>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-brand" id="detailDaftar">
                    Daftar Sekarang
                </button>
            </div>

        </div>
    </div>
</div>



<!-- MODAL PENDAFTARAN -->
<div class="modal fade" id="pendaftaranModal" tabindex="-1" aria-labelledby="pendaftaranModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog">
        <div class="modal-content rounded-4 border-0">

            <form id="formPendaftaran"
                  action="<?= site_url('pendaftaran/simpan') ?>"
                  method="post"
                  enctype="multipart/form-data">

                <?= csrf_field() ?>

                <input type="hidden" name="id_kegiatan" id="formIdKegiatan">

                <!-- HEADER -->
                <div class="modal-header">
                    <div>
                        <h5 class="modal-title fw-bold" id="pendaftaranModalTitle">
                            Formulir Pendaftaran
                        </h5>
                        <small class="text-secondary" id="formJudulKegiatan"></small>
                    </div>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Tutup"></button>
                </div>

                <!-- BODY -->
                <div class="modal-body">

                    <div id="pendaftaranAlert"></div>

                    <h6 class="fw-bold text-brand mb-3">
                        Data Peserta
                    </h6>

                    <div class="row g-3">

                        <!-- NAMA LENGKAP -->
                        <div class="col-md-6">
                            <label class="form-label">
                                Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   name="nama_lengkap"
                                   class="form-control"
                                   maxlength="150"
                                   placeholder="Masukkan nama lengkap"
                                   required>
                        </div>

                        <!-- NAMA PANGGILAN -->
                        <div class="col-md-6">
                            <label class="form-label">
                                Nama Panggilan <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   name="nama_panggilan"
                                   class="form-control"
                                   maxlength="100"
                                   placeholder="Masukkan nama panggilan"
                                   required>
                        </div>

                        <!-- EMAIL -->
                        <div class="col-md-6">
                            <label class="form-label">
                                Email <span class="text-danger">*</span>
                            </label>
                            <input type="email"
                                   name="email"
                                   class="form-control"
                                   maxlength="150"
                                   placeholder="nama@email.com"
                                   required>
                        </div>

                        <!-- WHATSAPP -->
                        <div class="col-md-6">
                            <label class="form-label">
                                Nomor WhatsApp <span class="text-danger">*</span>
                            </label>
                            <input type="tel"
                                   name="no_whatsapp"
                                   class="form-control"
                                   maxlength="20"
                                   placeholder="Contoh: 081234567890"
                                   required>
                        </div>

                        <!-- JENIS KELAMIN -->
                        <div class="col-md-6">
                            <label class="form-label">
                                Jenis Kelamin <span class="text-danger">*</span>
                            </label>
                            <select name="jenis_kelamin"
                                    class="form-select"
                                    required>
                                <option value="">Pilih jenis kelamin</option>
                                <option value="L">Laki-laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>

                        <!-- TANGGAL LAHIR -->
                        <div class="col-md-6">
                            <label class="form-label">
                                Tanggal Lahir <span class="text-danger">*</span>
                            </label>
                            <input type="date"
                                   name="tanggal_lahir"
                                   class="form-control"
                                   required>
                        </div>

                        <!-- DOMISILI -->
                        <div class="col-md-6">
                            <label class="form-label">
                                Domisili <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   name="domisili"
                                   class="form-control"
                                   maxlength="150"
                                   placeholder="Masukkan domisili"
                                   required>
                        </div>

                        <!-- INSTANSI -->
                        <div class="col-md-6">
                            <label class="form-label">
                                Instansi
                                <span class="text-secondary">(Opsional)</span>
                            </label>
                            <input type="text"
                                   name="instansi"
                                   class="form-control"
                                   maxlength="150"
                                   placeholder="Nama sekolah, kampus, atau organisasi">
                        </div>

                    </div>

                    <!-- PEMBAYARAN -->
                    <div id="bagianPembayaran" class="mt-4" style="display: none;">

                        <hr>

                        <h6 class="fw-bold text-brand mb-3">
                            Pembayaran
                        </h6>

                        <!-- JUMLAH PEMBAYARAN -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Total yang Harus Dibayar
                            </label>

                            <input type="text"
                                   id="jumlahPembayaranTampil"
                                   class="form-control fw-bold"
                                   readonly
                                   placeholder="Nominal pembayaran">

                            <input type="hidden"
                                   name="jumlah_pembayaran"
                                   id="jumlahPembayaran">
                        </div>

                        <!-- BUKTI PEMBAYARAN -->
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Bukti Pembayaran
                                <span class="text-danger">*</span>
                            </label>

                            <input type="file"
                                   name="bukti_pembayaran"
                                   id="buktiPembayaran"
                                   class="form-control"
                                   accept=".jpg,.jpeg,.png,.pdf">

                            <small class="text-secondary">
                                Format JPG, JPEG, PNG, atau PDF. Maksimal 2 MB.
                            </small>
                        </div>

                    </div>

                </div>

                <!-- FOOTER -->
                <div class="modal-footer">
                    <button type="button"
                            class="btn btn-light"
                            data-bs-dismiss="modal">
                        Batal
                    </button>

                    <button type="submit"
                            class="btn btn-brand"
                            id="btnKirimPendaftaran">
                        Kirim Pendaftaran
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>

<script>
    window.pendaftaranConfig = {
        urlSimpan: <?= json_encode(site_url('pendaftaran/simpan')) ?>,
        csrfName: <?= json_encode(csrf_token()) ?>,
        csrfHash: <?= json_encode(csrf_hash()) ?>
    };
</script>

<script src="<?= base_url('assets/js/kegiatan.js') ?>"></script>

<?= $this->endSection() ?>
