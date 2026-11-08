
<div class="modal fade" id="modalKegiatan" tabindex="-1" aria-labelledby="modalKegiatanTitle" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog">
        <div class="modal-content border-0 shadow">

            <!-- HEADER -->
            <div class="modal-header">
                <div>
                    <h5 class="modal-title fw-bold" id="modalKegiatanTitle">
                        Tambah Kegiatan
                    </h5>
                    <small class="text-secondary">
                        Lengkapi informasi kegiatan di bawah ini.
                    </small>
                </div>

                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <!-- FORM -->
            <form id="formKegiatan"
                  action="<?= site_url('superadmin/kegiatan/simpan') ?>"
                  method="post"
                  enctype="multipart/form-data">

                <?= csrf_field() ?>

                <div class="modal-body">

                    <!-- VALIDASI -->
                    <div id="pesanValidasi" class="alert alert-danger d-none">
                        <div class="fw-semibold mb-1">
                            Periksa kembali data berikut:
                        </div>
                        <ul class="mb-0" id="daftarError"></ul>
                    </div>

                    <div class="row g-3">

                        <!-- JUDUL -->
                        <div class="col-md-8">
                            <label class="form-label fw-semibold">
                                Judul Kegiatan <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   name="judul"
                                   class="form-control"
                                   placeholder="Masukkan judul kegiatan"
                                   maxlength="150"
                                   required>
                        </div>

                        <!-- KATEGORI -->
                        <div class="col-md-4">
                            <label class="form-label fw-semibold">
                                Kategori <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   name="kategori"
                                   class="form-control"
                                   placeholder="Contoh: Lingkungan"
                                   required>
                        </div>

                        <!-- TANGGAL -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Tanggal Kegiatan <span class="text-danger">*</span>
                            </label>
                            <input type="date"
                                   name="tanggal"
                                   class="form-control"
                                   required>
                        </div>

                        <!-- JAM -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Jam Kegiatan
                            </label>
                            <input type="time"
                                   name="jam"
                                   class="form-control">
                        </div>

                        <!-- LOKASI -->
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">
                                Lokasi <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   name="lokasi"
                                   class="form-control"
                                   placeholder="Masukkan lokasi kegiatan"
                                   maxlength="200"
                                   required>
                        </div>

                        <!-- DESKRIPSI -->
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">
                                Deskripsi <span class="text-danger">*</span>
                            </label>
                            <textarea name="deskripsi"
                                      class="form-control"
                                      rows="4"
                                      placeholder="Jelaskan detail kegiatan..."
                                      required></textarea>
                        </div>

                        <!-- KUOTA -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Kuota Peserta <span class="text-danger">*</span>
                            </label>
                            <input type="number"
                                   name="kuota"
                                   class="form-control"
                                   min="1"
                                   placeholder="Contoh: 100"
                                   required>
                        </div>

                        <!-- BATAS PENDAFTARAN -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Batas Pendaftaran
                            </label>
                            <input type="date"
                                   name="batas_pendaftaran"
                                   class="form-control">
                        </div>

                        <!-- JENIS BIAYA -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Jenis Biaya <span class="text-danger">*</span>
                            </label>
                            <select name="jenis_biaya"
                                    id="jenisBiaya"
                                    class="form-select"
                                    required>
                                <option value="gratis">Gratis</option>
                                <option value="berbayar">Berbayar</option>
                            </select>
                        </div>

                        <!-- BIAYA -->
                        <div class="col-md-6" id="kolomBiaya">
                            <label class="form-label fw-semibold">
                                Biaya Pendaftaran (Rp)
                            </label>
                            <input type="number"
                                   name="biaya_pendaftaran"
                                   id="biayaPendaftaran"
                                   class="form-control"
                                   min="0"
                                   step="1"
                                   value="0">
                        </div>

                        <!-- STATUS PENDAFTARAN -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Status Pendaftaran <span class="text-danger">*</span>
                            </label>
                            <select name="status_pendaftaran"
                                    class="form-select"
                                    required>
                                <option value="dibuka">Dibuka</option>
                                <option value="ditutup">Ditutup</option>
                            </select>
                        </div>

                        <!-- STATUS KEGIATAN -->
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">
                                Status Kegiatan <span class="text-danger">*</span>
                            </label>
                            <select name="aktif"
                                    class="form-select"
                                    required>
                                <option value="1">Aktif</option>
                                <option value="0">Nonaktif</option>
                            </select>
                        </div>

                        <!-- GAMBAR -->
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">
                                Poster Kegiatan
                                <span class="text-danger" id="wajibGambar">*</span>
                            </label>

                            <input type="file"
                                   name="gambar"
                                   id="gambarKegiatan"
                                   class="form-control"
                                   accept=".jpg,.jpeg,.png,.webp"
                                   required>

                            <small class="text-secondary">
                                Format JPG, JPEG, PNG, WEBP. Maksimal 2 MB.
                                Saat edit, kosongkan jika tidak ingin mengganti poster.
                            </small>

                            <!-- PREVIEW -->
                            <div id="previewGambar" class="mt-3 d-none">
                                <img src=""
                                     alt="Preview poster kegiatan"
                                     class="rounded border"
                                     style="width:180px;height:120px;object-fit:cover">
                            </div>
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
                            class="btn text-white"
                            id="btnSimpanKegiatan"
                            style="background:#f97316">
                        <i class="bi bi-save me-1"></i>
                        Simpan Kegiatan
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
