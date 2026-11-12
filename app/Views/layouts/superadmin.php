<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= esc($title ?? 'Admin Panel') ?> | TemanTebo</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <link href="<?= base_url('assets/css/admin.css') ?>" rel="stylesheet">
</head>

<body>

<div class="d-flex flex-column flex-md-row">

    <!-- ===== SIDEBAR ===== -->
    <aside class="admin-sidebar p-3" id="adminSidebar">

        <div class="sidebar-header d-flex align-items-center mb-4 px-1 pt-2">
            <a href="<?= site_url('superadmin') ?>" class="brand-logo" title="TemanTebo">
                <img src="<?= base_url('assets/img/temantebo.png') ?>" alt="TemanTebo">
            </a>
        </div>

        <div class="text-uppercase text-secondary small fw-semibold px-2 mb-2 section-label">
            Menu utama
        </div>

        <button type="button"
                class="admin-menu w-100 border-0 bg-transparent text-start <?= uri_string() === 'superadmin' ? 'active' : '' ?>"
                title="Dashboard"
                onclick="window.location.href='<?= site_url('superadmin') ?>'">
            <i class="bi bi-grid-1x2-fill"></i>
            <span class="menu-text">Dashboard</span>
        </button>

        <button type="button"
                class="admin-menu w-100 border-0 bg-transparent text-start <?= str_starts_with(uri_string(), 'superadmin/statistik') ? 'active' : '' ?>"
                title="Kelola Statistik"
                onclick="window.location.href='<?= site_url('superadmin/statistik') ?>'">
            <i class="bi bi-bar-chart-fill"></i>
            <span class="menu-text">Kelola Statistik</span>
        </button>

        <button type="button"
                class="admin-menu w-100 border-0 bg-transparent text-start <?= str_starts_with(uri_string(), 'superadmin/kegiatan') ? 'active' : '' ?>"
                title="Kelola Kegiatan"
                onclick="window.location.href='<?= site_url('superadmin/kegiatan') ?>'">
            <i class="bi bi-calendar-event-fill"></i>
            <span class="menu-text">Kelola Kegiatan</span>
        </button>

        <button type="button"
                class="admin-menu w-100 border-0 bg-transparent text-start <?= str_starts_with(uri_string(), 'superadmin/pendaftaran') ? 'active' : '' ?>"
                title="Kelola Pendaftaran"
                onclick="window.location.href='<?= site_url('superadmin/pendaftaran') ?>'">
            <i class="bi bi-clipboard-check-fill"></i>
            <span class="menu-text">Kelola Pendaftaran</span>
        </button>

        <button type="button"
                class="admin-menu w-100 border-0 bg-transparent text-start <?= str_starts_with(uri_string(), 'superadmin/kritiksaran') ? 'active' : '' ?>"
                title="Kritik & Saran"
                onclick="window.location.href='<?= site_url('superadmin/kritiksaran') ?>'">
            <i class="bi bi-chat-square-heart-fill"></i>
            <span class="menu-text">Kritik &amp; Saran</span>
        </button>

        <hr class="border-secondary my-4">

        <div class="text-uppercase text-secondary small fw-semibold px-2 mb-2 section-label">
            Lainnya
        </div>

        <button type="button"
                class="admin-menu w-100 border-0 bg-transparent text-start"
                title="Lihat Website"
                onclick="window.location.href='<?= site_url('/') ?>'">
            <i class="bi bi-globe"></i>
            <span class="menu-text">Lihat Website</span>
        </button>

        <form action="<?= url_to('logout') ?>" method="post">
            <?= csrf_field() ?>
            <button type="submit"
                    class="admin-menu w-100 border-0 bg-transparent text-start"
                    title="Keluar">
                <i class="bi bi-box-arrow-left"></i>
                <span class="menu-text">Keluar</span>
            </button>
        </form>

    </aside>

    <!-- ===== BACKDROP MOBILE ===== -->
    <div class="sidebar-backdrop" id="sidebarBackdrop"></div>

    <!-- ===== KONTEN ===== -->
    <div class="admin-content flex-grow-1">

        <header class="admin-topbar px-3 px-lg-4 py-3">
            <div class="d-flex justify-content-between align-items-center gap-3">

                <div class="d-flex align-items-center gap-2">
                    <button type="button" class="btn-toggle-sidebar" id="btnToggleSidebar" aria-label="Toggle menu">
                        <i class="bi bi-list fs-5"></i>
                    </button>
                    <div>
                        <div class="fw-semibold">Panel Administrasi</div>
                        <div class="text-secondary small">
                            Kelola platform TemanTebo
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle bg-warning-subtle text-warning d-flex align-items-center justify-content-center"
                         style="width: 40px; height: 40px;">
                        <i class="bi bi-person-fill fs-5"></i>
                    </div>
                    <div class="d-none d-sm-block">
                        <div class="fw-semibold small">
                            <?= esc(auth()->user()->username ?? 'Superadmin') ?>
                        </div>
                        <div class="text-secondary small">Super Admin</div>
                    </div>
                </div>

            </div>
        </header>

        <main class="admin-main p-3 p-lg-4">
            <?= $this->renderSection('content') ?>
        </main>

        <footer class="px-4 py-3 border-top bg-white text-secondary small">
            &copy; <?= date('Y') ?> TemanTebo. Panel administrasi.
        </footer>

    </div>

</div>

<!-- JQUERY -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

<!-- BOOTSTRAP JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- ADMIN JS -->
<script src="<?= base_url('assets/js/superadmin/admin.js') ?>"></script>

<!-- PAGE JAVASCRIPT -->
<?= $this->renderSection('scripts') ?>

</body>
</html>