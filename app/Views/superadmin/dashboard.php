<?= $this->extend('layouts/superadmin') ?>

<?= $this->section('content') ?>

<div class="mb-4">
    <h3 class="fw-bold mb-1">Dashboard</h3>
    <p class="text-secondary mb-0">
        Selamat datang di panel pengelolaan TemanTebo.
    </p>
</div>

<!-- STATISTIK -->
<div class="row g-3 mb-4">

    <div class="col-12 col-sm-6 col-xl-4" id="pengguna">
        <div class="card stat-card h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-secondary">Total Pengguna</span>
                    <div class="stat-icon">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-1" id="statPengguna">—</h3>
                <div class="small text-secondary">Data pengguna terdaftar</div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-4" id="kegiatan">
        <div class="card stat-card h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-secondary">Total Kegiatan</span>
                    <div class="stat-icon">
                        <i class="bi bi-calendar-event-fill"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-1" id="statKegiatan">—</h3>
                <div class="small text-secondary">Kegiatan yang dikelola</div>
            </div>
        </div>
    </div>

    <div class="col-12 col-sm-6 col-xl-4" id="komunitas">
        <div class="card stat-card h-100">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <span class="text-secondary">Total Komunitas</span>
                    <div class="stat-icon">
                        <i class="bi bi-diagram-3-fill"></i>
                    </div>
                </div>
                <h3 class="fw-bold mb-1" id="statKomunitas">—</h3>
                <div class="small text-secondary">Komunitas yang terdaftar</div>
            </div>
        </div>
    </div>

</div>

<!-- AKSES CEPAT -->
<div class="mb-4">
    <h5 class="fw-bold mb-3">Akses Cepat</h5>

    <div class="row g-3">
        <div class="col-12 col-md-6 col-xl-4">
            <div class="card stat-card h-100">
                <div class="card-body p-4">
                    <div class="stat-icon mb-3">
                        <i class="bi bi-person-gear"></i>
                    </div>
                    <h5 class="fw-bold">Kelola Pengguna</h5>
                    <p class="text-secondary small">
                        Kelola akun dan akses pengguna platform.
                    </p>
                    <span class="badge text-bg-secondary">Belum tersedia</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-4">
            <div class="card stat-card h-100">
                <div class="card-body p-4">
                    <div class="stat-icon mb-3">
                        <i class="bi bi-calendar2-check"></i>
                    </div>
                    <h5 class="fw-bold">Kelola Kegiatan</h5>
                    <p class="text-secondary small">
                        Kelola informasi kegiatan dan pendaftaran relawan.
                    </p>
                    <span class="badge text-bg-success">Tersedia</span>
                </div>
            </div>
        </div>

        <div class="col-12 col-md-6 col-xl-4" id="kritiksaran">
            <div class="card stat-card h-100">
                <div class="card-body p-4">
                    <div class="stat-icon mb-3">
                        <i class="bi bi-chat-square-text"></i>
                    </div>
                    <h5 class="fw-bold">Kritik & Saran</h5>
                    <p class="text-secondary small">
                        Lihat masukan dari pengguna TemanTebo.
                    </p>
                    <span class="badge text-bg-success">Tersedia</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- AKTIVITAS -->
<div class="card stat-card">
    <div class="card-body p-0">
        <div class="p-4 border-bottom">
            <h5 class="fw-bold mb-1">Aktivitas Terbaru</h5>
            <p class="text-secondary small mb-0">
                Ringkasan aktivitas platform akan ditampilkan di sini.
            </p>
        </div>

        <div class="p-4 text-center">
            <i class="bi bi-inbox text-secondary fs-1"></i>
            <p class="text-secondary mt-2 mb-0">
                Belum ada data aktivitas untuk ditampilkan.
            </p>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
// Placeholder — isi nanti saat endpoint statistik siap.
// Contoh:
// $.getJSON('<?= site_url('superadmin/dashboard/statistik') ?>', function (res) {
//     $('#statPengguna').text(res.pengguna);
//     $('#statKegiatan').text(res.kegiatan);
//     $('#statKomunitas').text(res.komunitas);
// });
</script>
<?= $this->endSection() ?>