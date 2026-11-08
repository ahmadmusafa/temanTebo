<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<?php
$warnaUtama = '#f97316';

$formatTanggal = static function ($tanggal) {
    if (empty($tanggal)) {
        return '-';
    }

    $bulan = [
        1 => 'Januari', 'Februari', 'Maret', 'April',
        'Mei', 'Juni', 'Juli', 'Agustus',
        'September', 'Oktober', 'November', 'Desember'
    ];

    $tanggalObj = strtotime($tanggal);

    return date('d', $tanggalObj) . ' ' .
        $bulan[(int) date('n', $tanggalObj)] . ' ' .
        date('Y', $tanggalObj);
};

$formatBiaya = static function ($event) {
    if (($event['jenis_biaya'] ?? '') === 'gratis') {
        return 'Gratis';
    }

    return 'Rp ' . number_format(
        (float) ($event['biaya_pendaftaran'] ?? 0),
        0,
        ',',
        '.'
    );
};
?>

<div class="container py-5">

    <!-- HEADER -->
    <div class="text-center mb-5">
        <h2 class="fw-bold">Kegiatan Relawan</h2>
        <p class="text-secondary">
            Temukan kegiatan menarik dan jadilah bagian dari perubahan.
        </p>
    </div>

    <!-- DAFTAR KEGIATAN -->
    <div class="row g-4">

        <?php if (!empty($kegiatan)): ?>

            <?php foreach ($kegiatan as $event): ?>

                <?php
                $dibuka = ($event['status_pendaftaran'] ?? '') === 'dibuka';

                $gambar = !empty($event['gambar'])
                    ? site_url('kegiatan/gambar/' . rawurlencode($event['gambar']))
                    : null;

                $lokasi = $event['lokasi'] ?? '';

                $dataEvent = [
                    'id'        => $event['id'],
                    'judul'     => $event['judul'],
                    'kategori'  => $event['kategori'] ?? '',
                    'gambar'    => $gambar,
                    'tanggal'   => $formatTanggal($event['tanggal']),
                    'jam'       => $event['jam'] ?: '-',
                    'lokasi'    => $lokasi,
                    'deskripsi' => $event['deskripsi'] ?? '',
                    'biaya'     => $formatBiaya($event),
                    'kuota'     => $event['kuota'] ?? 0,
                    'dibuka'    => $dibuka,
                    'map'       => 'https://www.google.com/maps/search/?api=1&query=' . rawurlencode($lokasi),
                ];

                $jsonEvent = esc(
                    json_encode(
                        $dataEvent,
                        JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP
                    ),
                    'attr'
                );
                ?>

                <div class="col-md-6 col-lg-4">

                    <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden event-card"
                         role="button"
                         tabindex="0"
                         data-event="<?= $jsonEvent ?>">

                        <!-- GAMBAR -->
                        <?php if ($gambar): ?>
                            <img
                                src="<?= esc($gambar) ?>"
                                class="card-img-top"
                                style="height: 210px; object-fit: cover;"
                                alt="<?= esc($event['judul']) ?>"
                            >
                        <?php else: ?>
                            <div class="bg-light d-flex align-items-center justify-content-center"
                                 style="height: 210px;">
                                <i class="bi bi-image fs-1 text-secondary"></i>
                            </div>
                        <?php endif; ?>

                        <!-- CARD BODY -->
                        <div class="card-body d-flex flex-column">

                            <div class="d-flex justify-content-between align-items-start gap-2 mb-2">

                                <h5 class="fw-bold mb-0">
                                    <?= esc($event['judul']) ?>
                                </h5>

                                <span class="badge <?= $dibuka ? 'text-bg-success' : 'text-bg-secondary' ?>">
                                    <?= $dibuka ? 'Available' : 'Closed' ?>
                                </span>

                            </div>

                            <!-- DESKRIPSI -->
                            <p class="text-secondary small text-truncate mb-3">
                                <?= esc($event['deskripsi'] ?? '') ?>
                            </p>

                            <!-- TANGGAL -->
                            <div class="small mb-2">
                                <i class="bi bi-calendar-event me-2"
                                   style="color: <?= $warnaUtama ?>;"></i>
                                <?= esc($dataEvent['tanggal']) ?>
                            </div>

                            <!-- LOKASI -->
                            <div class="small mb-3">
                                <i class="bi bi-geo-alt me-2"
                                   style="color: <?= $warnaUtama ?>;"></i>

                                <a
                                    href="<?= esc($dataEvent['map']) ?>"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                    class="text-decoration-none text-secondary"
                                    data-no-card-click
                                >
                                    <?= esc($lokasi ?: 'Lihat lokasi') ?>
                                </a>
                            </div>

                            <hr class="mt-auto">

                            <!-- HARGA DAN TOMBOL -->
                            <div class="d-flex justify-content-between align-items-center gap-2">

                                <div>
                                    <small class="text-secondary">
                                        Biaya kegiatan
                                    </small>

                                    <h5 class="fw-bold mb-0"
                                        style="color: <?= $warnaUtama ?>;">
                                        <?= esc($dataEvent['biaya']) ?>
                                    </h5>
                                </div>

                                <div class="d-flex gap-2">

                                    <button
                                        type="button"
                                        class="btn btn-sm border-2"
                                        style="border-color: <?= $warnaUtama ?>; color: <?= $warnaUtama ?>;"
                                        data-action="detail"
                                    >
                                        Detail
                                    </button>

                                    <button
                                        type="button"
                                        class="btn btn-sm text-white"
                                        style="background-color: <?= $warnaUtama ?>; border-color: <?= $warnaUtama ?>;"
                                        data-action="register"
                                        <?= !$dibuka ? 'disabled' : '' ?>
                                    >
                                        Daftar
                                    </button>

                                </div>

                            </div>

                        </div>
                    </div>

                </div>

            <?php endforeach; ?>

        <?php else: ?>

            <div class="col-12 text-center py-5">
                <i class="bi bi-calendar-x fs-1 text-secondary"></i>
                <p class="text-secondary mt-3">
                    Belum ada kegiatan tersedia.
                </p>
            </div>

        <?php endif; ?>

    </div>
</div>


<!-- MODAL DETAIL -->
<div class="modal fade" id="detailModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 border-0">

            <div class="modal-header">
                <h5 class="modal-title fw-bold" id="detailTitle">
                    Detail Kegiatan
                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <img
                    id="detailImage"
                    class="img-fluid rounded-3 w-100 mb-3"
                    style="max-height: 300px; object-fit: cover;"
                    alt="Foto kegiatan"
                >

                <div class="d-flex justify-content-between mb-3">
                    <span class="badge text-white"
                          id="detailCategory"
                          style="background-color: <?= $warnaUtama ?>;"></span>

                    <span class="badge" id="detailStatus"></span>
                </div>

                <p id="detailDescription" class="text-secondary"></p>

                <hr>

                <div class="row g-3">

                    <div class="col-md-6">
                        <i class="bi bi-calendar-event me-2"
                           style="color: <?= $warnaUtama ?>;"></i>
                        <span id="detailDate"></span>
                    </div>

                    <div class="col-md-6">
                        <i class="bi bi-clock me-2"
                           style="color: <?= $warnaUtama ?>;"></i>
                        <span id="detailTime"></span>
                    </div>

                    <div class="col-md-6">
                        <i class="bi bi-geo-alt me-2"
                           style="color: <?= $warnaUtama ?>;"></i>
                        <span id="detailLocation"></span>
                    </div>

                    <div class="col-md-6">
                        <i class="bi bi-people me-2"
                           style="color: <?= $warnaUtama ?>;"></i>
                        Kuota: <span id="detailQuota"></span>
                    </div>

                    <div class="col-12">
                        <i class="bi bi-cash me-2"
                           style="color: <?= $warnaUtama ?>;"></i>
                        <span id="detailPrice" class="fw-bold"></span>
                    </div>

                </div>

                <a
                    href="#"
                    target="_blank"
                    rel="noopener noreferrer"
                    id="detailMap"
                    class="btn btn-outline-secondary btn-sm mt-3"
                >
                    <i class="bi bi-map me-1"></i>
                    Lihat Google Maps
                </a>

            </div>

            <div class="modal-footer">
                <button
                    type="button"
                    class="btn text-white"
                    id="detailRegister"
                    style="background-color: <?= $warnaUtama ?>;"
                >
                    Daftar Sekarang
                </button>
            </div>

        </div>
    </div>
</div>


<!-- MODAL PENDAFTARAN -->
<div class="modal fade" id="registerModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content rounded-4 border-0">

            <div class="modal-header">
                <h5 class="modal-title fw-bold">
                    Pendaftaran Kegiatan
                </h5>

                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">

                <h6 id="registerEventTitle" class="fw-bold"></h6>

                <p class="text-secondary small" id="registerEventDate"></p>

                <input type="hidden" id="registerEventId">

                <div class="alert alert-info small mb-0">
                    Fitur pendaftaran masih berupa simulasi dan belum menyimpan data ke database.
                </div>

                <div id="registerMessage" class="mt-3"></div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    Tutup
                </button>

                <button
                    type="button"
                    class="btn text-white"
                    id="confirmRegister"
                    style="background-color: <?= $warnaUtama ?>;"
                >
                    Konfirmasi
                </button>
            </div>

        </div>
    </div>
</div>


<script>
document.addEventListener('DOMContentLoaded', function () {

    const detailModal = new bootstrap.Modal(
        document.getElementById('detailModal')
    );

    const registerModal = new bootstrap.Modal(
        document.getElementById('registerModal')
    );

    let selectedEvent = null;

    function showDetail(event) {
        selectedEvent = event;

        document.getElementById('detailTitle').textContent = event.judul;
        document.getElementById('detailCategory').textContent = event.kategori || '-';
        document.getElementById('detailDescription').textContent = event.deskripsi;
        document.getElementById('detailDate').textContent = event.tanggal;
        document.getElementById('detailTime').textContent = event.jam;
        document.getElementById('detailLocation').textContent = event.lokasi;
        document.getElementById('detailQuota').textContent = event.kuota;
        document.getElementById('detailPrice').textContent = event.biaya;
        document.getElementById('detailMap').href = event.map;

        const image = document.getElementById('detailImage');

        if (event.gambar) {
            image.src = event.gambar;
            image.classList.remove('d-none');
        } else {
            image.removeAttribute('src');
            image.classList.add('d-none');
        }

        const status = document.getElementById('detailStatus');

        status.textContent = event.dibuka ? 'Available' : 'Closed';
        status.className = event.dibuka
            ? 'badge text-bg-success'
            : 'badge text-bg-secondary';

        document.getElementById('detailRegister').disabled = !event.dibuka;

        detailModal.show();
    }

    function showRegister(event) {
        if (!event.dibuka) return;

        selectedEvent = event;

        document.getElementById('registerEventTitle').textContent = event.judul;
        document.getElementById('registerEventDate').textContent = event.tanggal;
        document.getElementById('registerEventId').value = event.id;
        document.getElementById('registerMessage').innerHTML = '';

        detailModal.hide();
        registerModal.show();
    }

    // KLIK CARD DAN TOMBOL
    document.querySelectorAll('.event-card').forEach(card => {

        function handleClick(e) {

            if (e.target.closest('[data-no-card-click], a')) {
                return;
            }

            const event = JSON.parse(card.dataset.event);
            const action = e.target.closest('[data-action]');

            if (action) {
                if (action.dataset.action === 'detail') {
                    showDetail(event);
                } else if (action.dataset.action === 'register') {
                    showRegister(event);
                }

                return;
            }

            showDetail(event);
        }

        card.addEventListener('click', handleClick);

        card.addEventListener('keydown', function (e) {
            if (e.target !== card) return;

            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                showDetail(JSON.parse(card.dataset.event));
            }
        });

    });

    // DAFTAR DARI MODAL DETAIL
    document.getElementById('detailRegister').addEventListener('click', function () {
        if (selectedEvent) {
            showRegister(selectedEvent);
        }
    });

    // KONFIRMASI PENDAFTARAN SIMULASI
    document.getElementById('confirmRegister').addEventListener('click', function () {

        document.getElementById('registerMessage').innerHTML = `
            <div class="alert alert-success mb-0">
                Pendaftaran simulasi berhasil. Fitur ini belum terhubung ke database.
            </div>
        `;

    });

});
</script>

<?= $this->endSection() ?>