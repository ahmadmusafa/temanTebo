<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
    /* Warna oranye. Mau ganti warna? Ubah kode #f97316 di sini saja. */
    .text-brand { color: #f97316; }
    .bg-brand   { background-color: #f97316; }

    .btn-brand {
        --bs-btn-color: #fff;
        --bs-btn-bg: #f97316;
        --bs-btn-border-color: #f97316;
        --bs-btn-hover-color: #fff;
        --bs-btn-hover-bg: #ea580c;
        --bs-btn-hover-border-color: #ea580c;
        --bs-btn-disabled-color: #fff;
        --bs-btn-disabled-bg: #f97316;
        --bs-btn-disabled-border-color: #f97316;
    }

    .btn-outline-brand {
        --bs-btn-color: #f97316;
        --bs-btn-border-color: #f97316;
        --bs-btn-border-width: 2px;
        --bs-btn-hover-color: #fff;
        --bs-btn-hover-bg: #f97316;
        --bs-btn-hover-border-color: #f97316;
    }

    .event-card { cursor: pointer; }
    .event-img  { height: 210px; object-fit: cover; }
</style>


<!-- ===================================================== -->
<!-- 1. DAFTAR KEGIATAN (kartu)                             -->
<!-- ===================================================== -->
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
            // Siapkan data yang dipakai kartu ini
            $dibuka = ($event['status_pendaftaran'] ?? '') === 'dibuka';
            $lokasi = $event['lokasi'] ?? '';
            $jam    = ($event['jam'] ?? '') ?: '-';
            $maps   = 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode($lokasi);

            $gambar = ! empty($event['gambar'])
                ? site_url('kegiatan/gambar/' . rawurlencode($event['gambar']))
                : '';

            $biaya = ($event['jenis_biaya'] ?? '') === 'gratis'
                ? 'Gratis'
                : 'Rp ' . number_format((float) ($event['biaya_pendaftaran'] ?? 0), 0, ',', '.');
            ?>

            <div class="col-md-6 col-lg-4">

                <!-- Data kegiatan disimpan di data-xxx, nanti dibaca oleh JavaScript -->
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
                    data-gambar="<?= esc($gambar, 'attr') ?>"
                    data-maps="<?= esc($maps, 'attr') ?>"
                    data-dibuka="<?= $dibuka ? '1' : '0' ?>"
                >

                    <!-- Gambar -->
                    <?php if ($gambar): ?>
                        <img src="<?= esc($gambar, 'attr') ?>" class="card-img-top event-img" alt="<?= esc($event['judul'], 'attr') ?>">
                    <?php else: ?>
                        <div class="event-img bg-light d-flex align-items-center justify-content-center">
                            <i class="bi bi-image fs-1 text-secondary"></i>
                        </div>
                    <?php endif; ?>

                    <div class="card-body d-flex flex-column">

                        <!-- Judul + status -->
                        <div class="d-flex justify-content-between gap-2 mb-2">
                            <h5 class="fw-bold mb-0"><?= esc($event['judul']) ?></h5>

                            <span class="badge <?= $dibuka ? 'text-bg-success' : 'text-bg-secondary' ?>">
                                <?= $dibuka ? 'Tersedia' : 'Di Tutup' ?>
                            </span>
                        </div>

                        <p class="text-secondary small text-truncate mb-3">
                            <?= esc($event['deskripsi'] ?? '') ?>
                        </p>

                        <!-- Lokasi -->
                        <div class="small mb-3">
                            <i class="bi bi-geo-alt text-brand me-2"></i>
                            <a href="<?= esc($maps, 'attr') ?>" target="_blank" rel="noopener noreferrer"
                               class="text-decoration-none text-secondary">
                                <?= esc($lokasi ?: 'Lihat lokasi') ?>
                            </a>
                        </div>

                        <hr class="mt-auto">

                        <!-- Tombol -->
                        <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-sm btn-outline-brand">
                                Detail
                            </button>

                            <button type="button" class="btn btn-sm btn-brand btn-daftar" <?= $dibuka ? '' : 'disabled' ?>>
                                Daftar
                            </button>
                        </div>

                    </div>
                </div>
            </div>

        <?php endforeach; ?>

    </div>
</div>


<!-- ===================================================== -->
<!-- 2. MODAL DETAIL                                        -->
<!-- ===================================================== -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 border-0">

            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="detailJudul"></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <img id="detailGambar" class="img-fluid rounded-3 w-100 mb-3"
                     style="max-height: 300px; object-fit: cover;" alt="Foto kegiatan">

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

                <a href="#" id="detailMaps" target="_blank" rel="noopener noreferrer"
                   class="btn btn-outline-secondary btn-sm mt-3">
                    <i class="bi bi-map me-1"></i> Lihat Google Maps
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


<!-- ===================================================== -->
<!-- 3. MODAL PENDAFTARAN                                   -->
<!-- ===================================================== -->
<div class="modal fade" id="daftarModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0">

            <div class="modal-header">
                <h5 class="modal-title fw-bold">Pendaftaran Kegiatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <h6 class="fw-bold" id="daftarJudul"></h6>
                <p class="text-secondary small" id="daftarTanggal"></p>

                <input type="hidden" id="daftarId">

                <div class="alert alert-info small mb-0">
                    Pendaftaran masih berupa simulasi dan belum menyimpan data ke database.
                </div>

                <div id="daftarPesan" class="mt-3"></div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-brand" id="daftarKonfirmasi">Konfirmasi</button>
            </div>

        </div>
    </div>
</div>

<?= $this->endSection() ?>


<!-- ===================================================== -->
<!-- 4. JAVASCRIPT                                          -->
<!-- ===================================================== -->
<?= $this->section('scripts') ?>

<script>
$(function () {

    const detailModal = new bootstrap.Modal(document.getElementById('detailModal'));
    const daftarModal = new bootstrap.Modal(document.getElementById('daftarModal'));

    let dipilih = null; // kegiatan yang sedang dibuka


    // "2026-11-12" -> "12 November 2026"
    function formatTanggal(tanggal) {
        if (!tanggal) return '-';

        return new Intl.DateTimeFormat('id-ID', {
            day: 'numeric', month: 'long', year: 'numeric'
        }).format(new Date(tanggal + 'T00:00:00'));
    }


    // Ambil data kegiatan dari atribut data-xxx milik kartu
    function ambilData(kartu) {
        const d = kartu.dataset;

        return {
            id: d.id,
            judul: d.judul,
            kategori: d.kategori || '-',
            deskripsi: d.deskripsi,
            tanggal: d.tanggal,
            jam: d.jam,
            lokasi: d.lokasi,
            kuota: d.kuota,
            biaya: d.biaya,
            gambar: d.gambar,
            maps: d.maps,
            dibuka: d.dibuka === '1'
        };
    }


    // Buka modal detail
    function bukaDetail(k) {
        dipilih = k;

        $('#detailJudul').text(k.judul);
        $('#detailKategori').text(k.kategori);
        $('#detailDeskripsi').text(k.deskripsi);
        $('#detailTanggal').text(formatTanggal(k.tanggal));
        $('#detailJam').text(k.jam);
        $('#detailLokasi').text(k.lokasi);
        $('#detailKuota').text(k.kuota);
        $('#detailBiaya').text(k.biaya);
        $('#detailMaps').attr('href', k.maps);

        // Gambar: tampil kalau ada, sembunyi kalau tidak
        if (k.gambar) {
            $('#detailGambar').attr('src', k.gambar).show();
        } else {
            $('#detailGambar').hide();
        }

        // Status: Available / Closed
        $('#detailStatus')
            .text(k.dibuka ? 'Available' : 'Closed')
            .removeClass('text-bg-success text-bg-secondary')
            .addClass(k.dibuka ? 'text-bg-success' : 'text-bg-secondary');

        $('#detailDaftar').prop('disabled', !k.dibuka);

        detailModal.show();
    }


    // Buka modal pendaftaran
    function bukaDaftar(k) {
        if (!k.dibuka) return;

        dipilih = k;

        $('#daftarJudul').text(k.judul);
        $('#daftarTanggal').text(formatTanggal(k.tanggal));
        $('#daftarId').val(k.id);
        $('#daftarPesan').empty();

        detailModal.hide();
        daftarModal.show();
    }


    // Klik kartu: tombol "Daftar" -> modal daftar, selain itu -> modal detail
    $('.event-card').on('click', function (e) {
        if ($(e.target).closest('a').length) return; // link Google Maps: biarkan

        const kegiatan = ambilData(this);

        if ($(e.target).closest('.btn-daftar').length) {
            bukaDaftar(kegiatan);
        } else {
            bukaDetail(kegiatan);
        }
    });

    // Keyboard: Enter / Spasi pada kartu membuka detail
    $('.event-card').on('keydown', function (e) {
        if (e.target !== this) return;

        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            bukaDetail(ambilData(this));
        }
    });

    // Tombol "Daftar Sekarang" di modal detail
    $('#detailDaftar').on('click', function () {
        if (dipilih) bukaDaftar(dipilih);
    });

    // Tombol "Konfirmasi" (masih simulasi, belum simpan ke database)
    $('#daftarKonfirmasi').on('click', function () {
        $('#daftarPesan').html(
            '<div class="alert alert-success mb-0">' +
            'Pendaftaran simulasi berhasil. Fitur ini belum terhubung ke database.' +
            '</div>'
        );
    });

});
</script>

<?= $this->endSection() ?>