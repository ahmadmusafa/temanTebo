<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#f97316">

    <title><?= esc($title ?? 'RuangAksi') ?> | TemanTebo</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <!-- CSS Utama -->
    <link rel="stylesheet" href="<?= base_url('assets/css/main.css') ?>">

    <?= $this->renderSection('styles') ?>
</head>

<body>

    <?php $halamanAktif = trim(uri_string(), '/'); ?>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container navbar-container">

            <!-- LOGO -->
            <a class="navbar-brand" href="<?= base_url('/') ?>">
                <img
                    src="<?= base_url('assets/img/temantebo.png') ?>"
                    alt="TemanTebo"
                    class="navbar-logo"
                >
            </a>

            <!-- HAMBURGER -->
            <button
                class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarRuangAksi"
                aria-controls="navbarRuangAksi"
                aria-expanded="false"
                aria-label="Buka navigasi"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- MENU -->
            <div class="collapse navbar-collapse" id="navbarRuangAksi">

                <ul class="navbar-nav mx-auto my-3 my-lg-0">

                    <li class="nav-item">
                        <a
                            class="nav-link <?= $halamanAktif === '' ? 'active' : '' ?>"
                            href="<?= base_url('/') ?>"
                            <?= $halamanAktif === '' ? 'aria-current="page"' : '' ?>
                        >
                            Beranda
                        </a>
                    </li>

                    <li class="nav-item">
                        <a
                            class="nav-link <?= $halamanAktif === 'kegiatan' ? 'active' : '' ?>"
                            href="<?= base_url('kegiatan') ?>"
                            <?= $halamanAktif === 'kegiatan' ? 'aria-current="page"' : '' ?>
                        >
                            Kegiatan
                        </a>
                    </li>

                    <li class="nav-item">
                        <a
                            class="nav-link <?= $halamanAktif === 'tentang-kami' ? 'active' : '' ?>"
                            href="<?= base_url('tentang-kami') ?>"
                            <?= $halamanAktif === 'tentang-kami' ? 'aria-current="page"' : '' ?>
                        >
                            Tentang Kami
                        </a>
                    </li>

                </ul>

                <!-- TOMBOL MASUK -->
                <div class="navbar-actions">
                    <a href="<?= base_url('login') ?>"
                       class="btn btn-outline-dark fw-semibold rounded-3 px-4 py-2">
                        Masuk
                    </a>
                </div>

            </div>
        </div>
    </nav>

    <!-- CONTENT -->
    <main>
        <?= $this->renderSection('content') ?>
    </main>

    <!-- FOOTER -->
    <footer class="footer">
        <div class="container">

            <div class="row g-4 mb-4">

                <div class="col-12 col-lg-5">
                    <a href="<?= base_url('/') ?>" class="footer-brand">
                        Teman<span class="text-warning">Tebo</span>
                    </a>

                    <p class="mt-3 mb-3 footer-description">
                        Ruang bagi generasi muda untuk bergerak,
                        berbagi, dan menciptakan dampak positif
                        melalui aksi sosial bersama.
                    </p>

                    <span class="small">
                        Inisiatif sosial bersama
                        <strong class="text-white">TemanTebo</strong>
                    </span>
                </div>

                <div class="col-6 col-lg-2">
                    <h6 class="text-white fw-bold mb-3">Jelajahi</h6>
                    <ul class="list-unstyled d-grid gap-2">
                        <li><a href="<?= base_url('kegiatan') ?>">Kegiatan</a></li>
                        <li><a href="<?= base_url('komunitas') ?>">Komunitas</a></li>
                        <li><a href="<?= base_url('dampak') ?>">Dampak Sosial</a></li>
                    </ul>
                </div>

                <div class="col-6 col-lg-2">
                    <h6 class="text-white fw-bold mb-3">RuangAksi</h6>
                    <ul class="list-unstyled d-grid gap-2">
                        <li><a href="<?= base_url('tentang') ?>">Tentang Kami</a></li>
                        <li><a href="<?= base_url('kontak') ?>">Kontak</a></li>
                        <li><a href="<?= base_url('login') ?>">Masuk</a></li>
                    </ul>
                </div>

                <div class="col-12 col-lg-3">
                    <h6 class="text-white fw-bold mb-3">Ikuti Pergerakan</h6>

                    <p class="small">
                        Temukan kegiatan dan jadilah bagian dari perubahan.
                    </p>

                    <a
                        href="https://www.instagram.com/temantebo.id/"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="btn btn-outline-light rounded-3"
                    >
                        <i class="bi bi-instagram me-2"></i>
                        @temantebo.id
                    </a>
                </div>

            </div>

            <hr class="footer-divider">

            <div class="footer-bottom">
                <span>
                    &copy; <?= date('Y') ?> Dibuat zZcode.
                    Dikembangkan bersama TemanTebo.
                </span>

                <span>Bergerak bersama, berdampak nyata.</span>
            </div>

        </div>
    </footer>

    <!-- JQUERY -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    <!-- BOOTSTRAP JAVASCRIPT -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JAVASCRIPT BERANDA -->
    <script src="<?= base_url('assets/js/beranda.js') ?>"></script>

    <!-- JAVASCRIPT HALAMAN -->
    <?= $this->renderSection('scripts') ?>

</body>
</html>
