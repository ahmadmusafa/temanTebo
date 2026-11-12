
<?= $this->extend('layouts/main') ?>

<?= $this->section('styles') ?>
<link rel="stylesheet" href="<?= base_url('assets/css/beranda.css') ?>">
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- HERO SLIDESHOW -->
<section class="hero-slider" id="heroSlider">

    <div class="hero-slide active" style="background-image: url('<?= base_url('assets/img/kegiatan1.JPG') ?>');"></div>
    <div class="hero-slide" style="background-image: url('<?= base_url('assets/img/kegiatan2.JPG') ?>');"></div>
    <div class="hero-slide" style="background-image: url('<?= base_url('assets/img/kegiatan3.JPG') ?>');"></div>
    <div class="hero-slide" style="background-image: url('<?= base_url('assets/img/kegiatan4.JPG') ?>');"></div>
    <div class="hero-slide" style="background-image: url('<?= base_url('assets/img/kegiatan5.JPG') ?>');"></div>

    <div class="container hero-content">
        <h1 class="hero-title">
            Anak Muda Bergerak,
            <span>Berdaya Berdampak.</span>
        </h1>

        <p class="hero-description">
            Temukan kegiatan sosial, bergabung dengan relawan,
            dan ciptakan dampak positif bersama TemanTebo.
        </p>

        <div class="mt-4">
            <a href="<?= base_url('kegiatan') ?>" class="btn btn-aksi btn-lg">
                Temukan Kegiatan
                <i class="bi bi-arrow-right ms-2"></i>
            </a>
        </div>
    </div>
</section>


<!-- STATISTIK -->
<section class="statistik-section">
    <div class="container">
        <div class="statistik-card">

            <div class="statistik-item">
                <div class="statistik-icon">
                    <i class="bi bi-people"></i>
                </div>

                <div class="statistik-info">
                    <h3>
                        <span class="counter" data-target="<?= esc($statistik['relawan'] ?? 0) ?>">0</span>
                        <span class="statistik-plus">+</span>
                    </h3>
                    <p>Relawan</p>
                </div>
            </div>

            <div class="statistik-item">
                <div class="statistik-icon">
                    <i class="bi bi-building"></i>
                </div>

                <div class="statistik-info">
                    <h3>
                        <span class="counter" data-target="<?= esc($statistik['organisasi'] ?? 0) ?>">0</span>
                        <span class="statistik-plus">+</span>
                    </h3>
                    <p>Organisasi</p>
                </div>
            </div>

            <div class="statistik-item">
                <div class="statistik-icon">
                    <i class="bi bi-heart-pulse"></i>
                </div>

                <div class="statistik-info">
                    <h3>
                        <span class="counter" data-target="<?= esc($statistik['aktivitas_sosial'] ?? 0) ?>">0</span>
                        <span class="statistik-plus">+</span>
                    </h3>
                    <p>Aktivitas Sosial</p>
                </div>
            </div>

        </div>
    </div>
</section>


<!-- EVENT TERBARU -->
<section class="event-section py-5" id="event">
    <div class="container py-3">

        <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
            <div>
                <h2 class="event-heading mt-2">
                    Temukan Kegiatan <span>Inspiratif</span>
                </h2>

                <p class="text-secondary mb-0">
                    Saatnya bergerak bersama dan memberikan dampak nyata.
                </p>
            </div>

            <a href="<?= base_url('kegiatan') ?>"
               class="btn rounded-pill px-4 event-all-button">
                Semua Event
                <i class="bi bi-arrow-up-right ms-1"></i>
            </a>
        </div>

        <div class="row g-4">

            <?php if (!empty($kegiatan)): ?>

                <?php foreach (array_slice($kegiatan, 0, 3) as $event): ?>

                    <?php
                        $gambar = !empty($event['gambar'])
                            ? base_url('kegiatan/gambar/' . rawurlencode($event['gambar']))
                            : '';

                        $tanggal = !empty($event['tanggal'])
                            ? date('d/m/Y', strtotime($event['tanggal']))
                            : '-';

                        $jenisBiaya = $event['jenis_biaya'] ?? '';

                        $biaya = $jenisBiaya === 'gratis'
                            ? 'Gratis'
                            : 'Rp ' . number_format(
                                (float) ($event['biaya_pendaftaran'] ?? 0),
                                0,
                                ',',
                                '.'
                            );

                        $statusDibuka = ($event['status_pendaftaran'] ?? '') === 'dibuka';

                        $maps = !empty($event['lokasi'])
                            ? 'https://www.google.com/maps/search/?api=1&query=' . urlencode($event['lokasi'])
                            : '';
                    ?>

                    <div class="col-md-6 col-lg-4">
                        <div class="event-card h-100">

                            <div class="event-image-wrapper">

                                <?php if ($gambar): ?>
                                    <img
                                        src="<?= esc($gambar) ?>"
                                        class="event-image"
                                        alt="<?= esc($event['judul']) ?>">
                                <?php else: ?>
                                    <div class="d-flex align-items-center justify-content-center h-100">
                                        <i class="bi bi-image fs-1 text-secondary"></i>
                                    </div>
                                <?php endif; ?>

                                <span class="event-category">
                                    <?= esc($event['kategori'] ?? 'Kegiatan') ?>
                                </span>

                            </div>

                            <div class="event-card-body">

                                <div class="event-date">
                                    <i class="bi bi-calendar-event"></i>
                                    <?= esc($tanggal) ?>
                                </div>

                                <h5 class="event-title">
                                    <?= esc($event['judul']) ?>
                                </h5>

                                <p class="event-description text-truncate">
                                    <?= esc($event['deskripsi'] ?? '') ?>
                                </p>

                                <div class="event-location mb-3">
                                    <i class="bi bi-geo-alt"></i>

                                    <?php if ($maps): ?>
                                        <a href="<?= esc($maps) ?>"
                                           target="_blank"
                                           rel="noopener noreferrer"
                                           class="text-secondary text-decoration-none">
                                            <?= esc($event['lokasi']) ?>
                                        </a>
                                    <?php else: ?>
                                        <span>-</span>
                                    <?php endif; ?>
                                </div>

                                <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

                                    <strong class="event-price">
                                        <?= esc($biaya) ?>
                                    </strong>

                                    <span class="badge <?= $statusDibuka ? 'bg-success' : 'bg-secondary' ?>">
                                        <?= $statusDibuka ? 'Tersedia' : 'Di Tutup' ?>
                                    </span>

                                </div>

                                <button
                                    type="button"
                                    class="btn btn-event-detail w-100 mt-3"
                                    data-bs-toggle="modal"
                                    data-bs-target="#modalEvent"
                                    data-title="<?= esc($event['judul'], 'attr') ?>"
                                    data-category="<?= esc($event['kategori'] ?? 'Kegiatan', 'attr') ?>"
                                    data-date="<?= esc($tanggal, 'attr') ?>"
                                    data-location="<?= esc($event['lokasi'] ?? '-', 'attr') ?>"
                                    data-image="<?= esc($gambar, 'attr') ?>"
                                    data-description="<?= esc($event['deskripsi'] ?? '', 'attr') ?>">

                                    Lihat Detail Event
                                    <i class="bi bi-arrow-right ms-2"></i>
                                </button>

                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>

            <?php else: ?>

                <div class="col-12">
                    <div class="text-center py-5">
                        <i class="bi bi-calendar-x fs-1 text-secondary"></i>

                        <h5 class="mt-3">Belum Ada Kegiatan</h5>

                        <p class="text-secondary mb-0">
                            Saat ini belum ada kegiatan yang tersedia.
                        </p>
                    </div>
                </div>

            <?php endif; ?>

        </div>
    </div>
</section>


<!-- MODAL DETAIL EVENT -->
<div class="modal fade"
     id="modalEvent"
     tabindex="-1"
     aria-labelledby="modalEventLabel"
     aria-hidden="true">

    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content event-modal-content">

            <div class="modal-header border-0 pb-0">
                <span class="event-label">
                    <i class="bi bi-calendar-heart me-1"></i>
                    DETAIL EVENT
                </span>

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="modal"
                        aria-label="Tutup"></button>
            </div>

            <div class="modal-body p-4 pt-3">

                <img id="detailEventImage"
                     src=""
                     class="event-modal-image mb-4"
                     alt="Foto event">

                <span id="detailEventCategory" class="event-category-modal"></span>

                <h3 id="modalEventLabel" class="event-modal-title mt-3"></h3>

                <div class="event-modal-meta mt-3">
                    <div>
                        <i class="bi bi-calendar-event"></i>
                        <span id="detailEventDate"></span>
                    </div>

                    <div>
                        <i class="bi bi-geo-alt"></i>
                        <span id="detailEventLocation"></span>
                    </div>
                </div>

                <hr class="my-4">

                <h6 class="fw-bold">Tentang Event</h6>

                <p id="detailEventDescription" class="text-secondary event-modal-description"></p>

            </div>

            <div class="modal-footer border-0 px-4 pb-4">
                <button type="button"
                        class="btn btn-light rounded-pill px-4"
                        data-bs-dismiss="modal">
                    Tutup
                </button>

                <a href="<?= base_url('kegiatan') ?>"
                   class="btn btn-aksi rounded-pill px-4">
                    Jelajahi Kegiatan
                    <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>

        </div>
    </div>
</div>


<!-- KRITIK DAN SARAN -->
<?php
    $errorsKritik = session()->getFlashdata('errors_kritik') ?? [];
    $sukses = session()->getFlashdata('kritik_sukses');
    $gagal = session()->getFlashdata('kritik_gagal');
?>

<section class="feedback-section py-5" id="kritiksaran">
    <div class="container py-3">
        <div class="row justify-content-center">
            <div class="col-lg-8">

                <div class="text-center mb-4">
                    <h2 class="event-heading mt-2">
                        Kritik <span>& Saran</span>
                    </h2>

                    <p class="text-secondary mb-0">
                        Bantu kami menjadi lebih baik. Sampaikan kritik,
                        saran, atau ide Anda untuk TemanTebo.
                    </p>
                </div>

                <?php if ($sukses): ?>
                    <div class="alert alert-success d-flex align-items-center rounded-4" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <div><?= esc($sukses) ?></div>
                    </div>
                <?php endif; ?>

                <?php if ($gagal): ?>
                    <div class="alert alert-danger d-flex align-items-center rounded-4" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <div><?= esc($gagal) ?></div>
                    </div>
                <?php endif; ?>

                <form action="<?= base_url('kritiksaran/kirim') ?>"
                      method="post"
                      class="feedback-card"
                      novalidate>

                    <?= csrf_field() ?>

                    <div class="feedback-hp" aria-hidden="true">
                        <label for="website">Website</label>
                        <input type="text"
                               name="website"
                               id="website"
                               tabindex="-1"
                               autocomplete="off">
                    </div>

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label for="kritikNama" class="form-label">
                                Nama <span class="text-danger">*</span>
                            </label>

                            <input type="text"
                                   id="kritikNama"
                                   name="nama"
                                   maxlength="100"
                                   class="form-control <?= isset($errorsKritik['nama']) ? 'is-invalid' : '' ?>"
                                   placeholder="Nama lengkap Anda"
                                   value="<?= esc(old('nama')) ?>"
                                   required>

                            <?php if (isset($errorsKritik['nama'])): ?>
                                <div class="invalid-feedback">
                                    <?= esc($errorsKritik['nama']) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="col-md-6">
                            <label for="kritikEmail" class="form-label">
                                Email <span class="text-secondary fw-normal">(opsional)</span>
                            </label>

                            <input type="email"
                                   id="kritikEmail"
                                   name="email"
                                   maxlength="150"
                                   class="form-control <?= isset($errorsKritik['email']) ? 'is-invalid' : '' ?>"
                                   placeholder="nama@email.com"
                                   value="<?= esc(old('email')) ?>">

                            <?php if (isset($errorsKritik['email'])): ?>
                                <div class="invalid-feedback">
                                    <?= esc($errorsKritik['email']) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="col-12">
                            <label for="kritikJenis" class="form-label">
                                Jenis Masukan <span class="text-danger">*</span>
                            </label>

                            <select id="kritikJenis"
                                    name="jenis"
                                    class="form-select <?= isset($errorsKritik['jenis']) ? 'is-invalid' : '' ?>"
                                    required>
                                <option value="saran" <?= old('jenis') !== 'kritik' ? 'selected' : '' ?>>
                                    Saran
                                </option>
                                <option value="kritik" <?= old('jenis') === 'kritik' ? 'selected' : '' ?>>
                                    Kritik
                                </option>
                            </select>

                            <?php if (isset($errorsKritik['jenis'])): ?>
                                <div class="invalid-feedback">
                                    <?= esc($errorsKritik['jenis']) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="col-12">
                            <label for="kritikPesan" class="form-label">
                                Pesan <span class="text-danger">*</span>
                            </label>

                            <textarea id="kritikPesan"
                                      name="pesan"
                                      rows="5"
                                      maxlength="1000"
                                      class="form-control <?= isset($errorsKritik['pesan']) ? 'is-invalid' : '' ?>"
                                      placeholder="Tulis kritik atau saran Anda di sini..."
                                      required><?= esc(old('pesan')) ?></textarea>

                            <?php if (isset($errorsKritik['pesan'])): ?>
                                <div class="invalid-feedback">
                                    <?= esc($errorsKritik['pesan']) ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="col-12 text-center mt-4">
                            <button type="submit"
                                    class="btn btn-aksi btn-lg rounded-pill px-5">
                                Kirim Masukan
                                <i class="bi bi-send ms-2"></i>
                            </button>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>
</section>


<!-- OUR PARTNERS -->
<section class="partners-section py-5">
    <div class="container text-center py-3">

        <span class="event-label">
            Terbuka Untuk kolaborasi
        </span>

        <h2 class="partners-heading mt-2">
            Our <span>Partners</span>
        </h2>

    </div>

    <div class="partners-marquee">
        <div class="partners-track">

            <div class="partner-logo">
                <img src="<?= base_url('assets/img/partners/zzcode.jpeg') ?>" alt="zZcode">
            </div>

            <div class="partner-logo">
                <img src="<?= base_url('assets/img/partners/amalbaik.jpeg') ?>" alt="Amal Baik">
            </div>

            <div class="partner-logo">
                <img src="<?= base_url('assets/img/partners/swaka1.PNG') ?>" alt="Swaka">
            </div>

            <div class="partner-logo">
                <img src="<?= base_url('assets/img/partners/swaka2.PNG') ?>" alt="Swaka">
            </div>

            <div class="partner-logo">
                <img src="<?= base_url('assets/img/partners/dispusip.PNG') ?>" alt="Dispusip">
            </div>

            <div class="partner-logo">
                <img src="<?= base_url('assets/img/partners/mainyuk.jpeg') ?>" alt="Main Yuk">
            </div>

            <!-- Duplikat untuk animasi -->
            <div class="partner-logo" aria-hidden="true">
                <img src="<?= base_url('assets/img/partners/zzcode.jpeg') ?>" alt="">
            </div>

            <div class="partner-logo" aria-hidden="true">
                <img src="<?= base_url('assets/img/partners/amalbaik.jpeg') ?>" alt="">
            </div>

            <div class="partner-logo" aria-hidden="true">
                <img src="<?= base_url('assets/img/partners/swaka1.PNG') ?>" alt="">
            </div>

            <div class="partner-logo" aria-hidden="true">
                <img src="<?= base_url('assets/img/partners/swaka2.PNG') ?>" alt="">
            </div>

            <div class="partner-logo" aria-hidden="true">
                <img src="<?= base_url('assets/img/partners/dispusip.PNG') ?>" alt="">
            </div>

            <div class="partner-logo" aria-hidden="true">
                <img src="<?= base_url('assets/img/partners/mainyuk.jpeg') ?>" alt="">
            </div>

        </div>
    </div>
</section>

<?= $this->endSection() ?>


<?= $this->section('scripts') ?>
<script src="<?= base_url('assets/js/beranda.js') ?>"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var modalEl = document.getElementById('modalEvent');

        if (!modalEl) return;

        modalEl.addEventListener('show.bs.modal', function (e) {
            var btn = e.relatedTarget;

            if (!btn) return;

            var d = btn.dataset;
            var img = document.getElementById('detailEventImage');
            var desc = document.getElementById('detailEventDescription');

            document.getElementById('modalEventLabel').textContent = d.title || '';
            document.getElementById('detailEventCategory').textContent = d.category || '';
            document.getElementById('detailEventDate').textContent = d.date || '-';
            document.getElementById('detailEventLocation').textContent = d.location || '-';

            desc.textContent = d.description || 'Belum ada deskripsi.';
            desc.style.whiteSpace = 'pre-line';

            if (d.image) {
                img.src = d.image;
                img.alt = d.title || 'Foto event';
                img.style.display = '';
            } else {
                img.removeAttribute('src');
                img.style.display = 'none';
            }
        });
    });
</script>
<?= $this->endSection() ?>
