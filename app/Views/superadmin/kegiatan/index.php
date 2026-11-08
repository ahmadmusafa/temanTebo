<?= $this->extend('layouts/superadmin') ?>
<?= $this->section('content') ?>

<!-- HEADER -->
<div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
    <div>
        <h4 class="fw-bold mb-1">Kelola Kegiatan</h4>
        <p class="text-secondary mb-0">Kelola seluruh kegiatan TemanTebo.</p>
    </div>

    <button type="button"
            class="btn text-white"
            id="btnTambahKegiatan"
            style="background:#f97316">
        <i class="bi bi-plus-lg me-1"></i>
        Tambah Kegiatan
    </button>
</div>

<!-- NOTIFIKASI -->
<div id="notifikasiKegiatan"></div>

<!-- DAFTAR KEGIATAN -->
<div id="daftarKegiatan">
    <div class="card stat-card">
        <div class="card-body p-0">

            <div class="d-flex justify-content-between align-items-center p-3 border-bottom">
                <h6 class="fw-bold mb-0">Daftar Kegiatan</h6>

                <span class="badge text-bg-light">
                    Total: <?= count($kegiatan) ?>
                </span>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="ps-3">No.</th>
                            <th>Gambar</th>
                            <th>Kegiatan</th>
                            <th>Tanggal</th>
                            <th>Kuota</th>
                            <th>Status</th>
                            <th class="text-end pe-3">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php if (empty($kegiatan)): ?>
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="bi bi-calendar-x fs-2 text-secondary"></i>
                                    <p class="text-secondary mt-2 mb-0">
                                        Belum ada kegiatan.
                                    </p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($kegiatan as $i => $item): ?>
                                <tr>
                                    <td class="ps-3"><?= $i + 1 ?></td>

                                    <!-- GAMBAR -->
                                    <td>
                                        <?php if (! empty($item['gambar'])): ?>
                                            <img
                                                src="<?= base_url('uploads/kegiatan/' . $item['gambar']) ?>"
                                                alt="<?= esc($item['judul']) ?>"
                                                class="rounded"
                                                style="width:64px;height:48px;object-fit:cover"
                                            >
                                        <?php else: ?>
                                            <div class="rounded bg-light d-flex align-items-center justify-content-center"
                                                 style="width:64px;height:48px">
                                                <i class="bi bi-image text-secondary fs-5"></i>
                                            </div>
                                        <?php endif ?>
                                    </td>

                                    <!-- INFORMASI KEGIATAN -->
                                    <td>
                                        <div class="fw-semibold">
                                            <?= esc($item['judul']) ?>
                                        </div>

                                        <small class="text-secondary">
                                            <?= esc($item['kategori']) ?>
                                        </small>
                                    </td>

                                    <!-- TANGGAL -->
                                    <td>
                                        <?= esc(date('d M Y', strtotime($item['tanggal']))) ?>
                                    </td>

                                    <!-- KUOTA -->
                                    <td>
                                        <?= esc($item['kuota']) ?> orang
                                    </td>

                                    <!-- STATUS -->
                                    <td>
                                        <?php if ($item['aktif'] && $item['status_pendaftaran'] === 'dibuka'): ?>
                                            <span class="badge rounded-pill text-bg-success">
                                                Dibuka
                                            </span>
                                        <?php else: ?>
                                            <span class="badge rounded-pill text-bg-secondary">
                                                Ditutup
                                            </span>
                                        <?php endif ?>
                                    </td>

                                    <!-- AKSI -->
                                    <td class="text-end pe-3">

                                        <!-- EDIT -->
                                        <button type="button"
                                                class="btn btn-sm btn-outline-primary btnEditKegiatan"
                                                data-id="<?= esc($item['id']) ?>"
                                                title="Edit kegiatan">
                                            <i class="bi bi-pencil"></i>
                                        </button>

                                        <!-- HAPUS -->
                                        <form action="<?= site_url('superadmin/kegiatan/hapus/' . $item['id']) ?>"
                                              method="post"
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus kegiatan ini?')">

                                            <?= csrf_field() ?>

                                            <button type="submit"
                                                    class="btn btn-sm btn-outline-danger"
                                                    title="Hapus kegiatan">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>

                                    </td>
                                </tr>
                            <?php endforeach ?>
                        <?php endif ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<!-- MODAL TAMBAH DAN EDIT -->
<?= $this->include('superadmin/kegiatan/modal') ?>

<?= $this->endSection() ?>


<!-- JAVASCRIPT HALAMAN -->
<?= $this->section('scripts') ?>

<script>
    window.kegiatanConfig = {
        urlSimpan: "<?= site_url('superadmin/kegiatan/simpan') ?>",
        urlData: "<?= site_url('superadmin/kegiatan/data') ?>",
        urlUpdate: "<?= site_url('superadmin/kegiatan/update') ?>",
        urlGambar: "<?= base_url('uploads/kegiatan/') ?>"
    };
</script>

<script src="<?= base_url('assets/js/superadmin/kegiatan.js') ?>"></script>

<?= $this->endSection() ?>
