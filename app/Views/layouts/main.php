<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#f97316">

    <title><?= esc($title ?? 'RuangAksi') ?> | TemanTebo</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
          rel="stylesheet">

    <link rel="stylesheet" href="<?= base_url('assets/css/beranda.css') ?>">


    <style>
        :root {
            --primary: #f97316;
            --primary-dark: #ea580c;
            --dark: #171717;
            --light: #fff7ed;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: system-ui, -apple-system, sans-serif;
            color: var(--dark);
            background: #fff;
            overflow-x: hidden;
        }

        a {
            text-decoration: none;
        }

        /* ================= NAVBAR ================= */
        .navbar {
            background: rgba(255, 255, 255, 0.97);
            border-bottom: 1px solid #f1f1f1;
            backdrop-filter: blur(12px);
        }

        .navbar-container {
            min-height: 76px;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
        }

        .navbar-brand {
            margin: 0;
            padding: 0;
            flex-shrink: 0;
            line-height: 0;
        }

        .navbar-logo {
            display: block;
            width: auto;
            height: 55px;
            max-width: min(65vw, 300px);
            object-fit: contain;
        }

        .navbar-toggler {
            margin-left: auto;
            border: 1px solid #e5e5e5;
            border-radius: 8px;
            padding: 7px 10px;
        }

        .navbar-toggler:focus {
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.2);
        }

        .navbar-nav .nav-link {
            color: #525252;
            font-weight: 600;
            padding: 10px 12px;
            transition: color 0.2s ease;
        }

        .navbar-nav .nav-link:hover,
        .navbar-nav .nav-link.active {
            color: var(--primary);
        }

        .navbar-actions {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* ================= BUTTON ================= */
        .btn-aksi {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: var(--primary);
            color: #fff;
            font-weight: 700;
            border: 0;
            border-radius: 10px;
            padding: 11px 18px;
            white-space: nowrap;
            transition: background 0.2s ease;
        }

        .btn-aksi:hover,
        .btn-aksi:focus {
            background: var(--primary-dark);
            color: #fff;
        }

        /* ================= MAIN CONTENT ================= */
        main {
            min-height: 70vh;
            min-width: 0;
        }

        /* ================= FOOTER ================= */
        .footer {
            background: var(--dark);
            color: #d4d4d4;
            padding: 48px 0 20px;
        }

        .footer .footer-brand {
            color: #fff;
            font-size: 1.5rem;
            font-weight: 800;
        }

        .footer a {
            color: #d4d4d4;
            transition: color 0.2s ease;
        }

        .footer a:hover {
            color: #fb923c;
        }

        .footer-description {
            max-width: 390px;
            line-height: 1.8;
        }

        .footer-divider {
            border-color: #404040;
        }

        .footer-bottom {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            padding-top: 8px;
            font-size: 0.875rem;
        }

        /* ================= DESKTOP ================= */
        @media (min-width: 992px) {
            .navbar-container {
                flex-wrap: nowrap;
                gap: 20px;
            }

            .navbar-collapse {
                flex: 1;
                align-items: center;
                justify-content: space-between;
                min-width: 0;
            }

            .navbar-nav {
                flex-direction: row;
            }

            .navbar-nav .nav-link {
                padding-left: 9px;
                padding-right: 9px;
                white-space: nowrap;
            }

            .navbar-actions .btn {
                white-space: nowrap;
            }
        }

        /* ================= TABLET DAN HP ================= */
        @media (max-width: 991.98px) {
            .navbar-container {
                min-height: 68px;
                padding-top: 10px;
                padding-bottom: 10px;
            }

            .navbar-logo {
                height: 45px;
            }

            .navbar-collapse {
                flex-basis: 100%;
                width: 100%;
                padding-top: 12px;
            }

            .navbar-nav {
                margin-top: 0;
                margin-bottom: 12px;
            }

            .navbar-nav .nav-link {
                padding: 10px 4px;
            }

            .navbar-actions {
                flex-direction: column;
                align-items: stretch;
                width: 100%;
                padding-bottom: 8px;
            }

            .navbar-actions .btn {
                width: 100%;
                text-align: center;
            }

            .footer {
                padding-top: 36px;
            }

            .footer-bottom {
                flex-direction: column;
                gap: 8px;
            }
        }

        /* ================= HP KECIL ================= */
        @media (max-width: 575.98px) {
            .navbar-container {
                min-height: 60px;
            }

            .navbar-logo {
                height: 40px;
                max-width: min(70vw, 260px);
            }

            .footer {
                padding-top: 30px;
            }

            .footer .footer-brand {
                font-size: 1.35rem;
            }

            .footer-bottom {
                font-size: 0.8rem;
                overflow-wrap: anywhere;
            }
        }

        /* ================= AKSESIBILITAS ================= */
        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>

    <?= $this->renderSection('styles') ?>
</head>

<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg sticky-top">
        <div class="container navbar-container">

            <!-- LOGO TEMANTEBO -->
            <a class="navbar-brand" href="<?= base_url('/') ?>">
                <img
                    src="<?= base_url('assets/img/temantebo.png') ?>"
                    alt="TemanTebo - Muda Bergerak, Berdaya Berdampak"
                    class="navbar-logo"
                >
            </a>

            <!-- TOMBOL HAMBURGER -->
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

            <!-- MENU NAVIGASI -->
            <div class="collapse navbar-collapse" id="navbarRuangAksi">

                <ul class="navbar-nav mx-auto my-3 my-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('/') ?>">
                            Beranda
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('kegiatan') ?>">
                            Kegiatan
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="<?= base_url('tentang-kami') ?>">
                            Tentang Kami
                        </a>
                    </li>
                </ul>

                <!-- TOMBOL AKSI -->
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
                        <li>
                            <a href="<?= base_url('kegiatan') ?>">Kegiatan</a>
                        </li>
                        <li>
                            <a href="<?= base_url('komunitas') ?>">Komunitas</a>
                        </li>
                        <li>
                            <a href="<?= base_url('dampak') ?>">Dampak Sosial</a>
                        </li>
                    </ul>
                </div>

                <div class="col-6 col-lg-2">
                    <h6 class="text-white fw-bold mb-3">RuangAksi</h6>
                    <ul class="list-unstyled d-grid gap-2">
                        <li>
                            <a href="<?= base_url('tentang') ?>">Tentang Kami</a>
                        </li>
                        <li>
                            <a href="<?= base_url('kontak') ?>">Kontak</a>
                        </li>
                        <li>
                            <a href="<?= base_url('login') ?>">Masuk</a>
                        </li>
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

    <!-- BOOTSTRAP JAVASCRIPT -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- JAVASCRIPT BERANDA -->
    <script src="<?= base_url('assets/js/beranda.js') ?>"></script>

    <?= $this->renderSection('scripts') ?>

</body>
</html>