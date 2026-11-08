$(function () {
    const config = window.kegiatanConfig;

    const modalElement = document.getElementById('modalKegiatan');
    const modal = bootstrap.Modal.getOrCreateInstance(modalElement);

    const form = $('#formKegiatan');
    const tombolSimpan = $('#btnSimpanKegiatan');
    const biayaInput = $('#biayaPendaftaran');

    let modeForm = 'tambah';

    // ================= FORMAT RIBUAN =================
    function formatRibuan(value) {
        const raw = String(value ?? '').split('.')[0].replace(/\D/g, '');
        return raw.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
    }

    function cleanRibuan(value) {
        return String(value ?? '').replace(/\./g, '');
    }

    biayaInput.on('input', function () {
        const digitsBefore = this.value
            .slice(0, this.selectionStart)
            .replace(/\D/g, '').length;

        this.value = formatRibuan(this.value);

        // Kembalikan kursor berdasarkan jumlah digit sebelum posisi lama
        let count = 0;
        let pos = 0;
        for (let i = 0; i < this.value.length; i++) {
            if (count >= digitsBefore) { pos = i; break; }
            if (/\d/.test(this.value[i])) count++;
            pos = i + 1;
        }
        this.setSelectionRange(pos, pos);
    });

    // ================= RESET FORM =================
    function resetForm() {
        form[0].reset();
        biayaInput.removeData('last');

        form.attr('action', config.urlSimpan);
        modeForm = 'tambah';

        $('#modalKegiatanTitle').text('Tambah Kegiatan');
        tombolSimpan.html('<i class="bi bi-save me-1"></i> Simpan Kegiatan');

        $('#pesanValidasi').addClass('d-none');
        $('#daftarError').empty();

        $('#previewGambar').addClass('d-none');
        $('#previewGambar img').attr('src', '');

        $('#gambarKegiatan').prop('required', true);
        $('#wajibGambar').removeClass('d-none');

        aturBiaya();
    }

    // ================= ATUR BIAYA =================
    // Hanya sync tampilan — TIDAK menyentuh value
    function aturBiaya() {
        const gratis = $('#jenisBiaya').val() === 'gratis';
        $('#kolomBiaya').toggle(!gratis);
        biayaInput.prop('disabled', gratis).prop('required', !gratis);
    }

    // Value hanya berubah saat USER ganti jenis (bukan saat populate)
    $('#jenisBiaya').on('change', function () {
        if ($(this).val() === 'gratis') {
            biayaInput.data('last', biayaInput.val());
            biayaInput.val('0');
        } else {
            const last = biayaInput.data('last');
            if (last !== undefined && last !== '') biayaInput.val(last);
        }
        aturBiaya();
    });

    // ================= PREVIEW GAMBAR =================
    $('#gambarKegiatan').on('change', function () {
        const file = this.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function (event) {
            $('#previewGambar img').attr('src', event.target.result);
            $('#previewGambar').removeClass('d-none');
        };
        reader.readAsDataURL(file);
    });

    // ================= TOMBOL TAMBAH =================
    $('#btnTambahKegiatan').on('click', function () {
        resetForm();
        modal.show();
    });

    // ================= TOMBOL EDIT =================
    $(document).on('click', '.btnEditKegiatan', function () {
        const id = $(this).data('id');

        resetForm();
        modeForm = 'edit';

        $('#modalKegiatanTitle').text('Edit Kegiatan');
        tombolSimpan.html('<i class="bi bi-save me-1"></i> Simpan Perubahan');

        $('#gambarKegiatan').prop('required', false);
        $('#wajibGambar').addClass('d-none');

        $.ajax({
            url: config.urlData + '/' + id,
            type: 'GET',
            dataType: 'json',

            success: function (response) {
                if (!response.status) {
                    tampilkanPesan(response.message || 'Data tidak ditemukan.', 'danger');
                    return;
                }

                const kegiatan = response.kegiatan;

                $.each(kegiatan, function (key, value) {
                    const field = form.find('[name="' + key + '"]');
                    if (!field.length || key === 'gambar') return;

                    field.val(
                        key === 'biaya_pendaftaran'
                            ? formatRibuan(parseInt(value, 10) || 0)
                            : (value ?? '')
                    );
                });

                form.attr('action', config.urlUpdate + '/' + id);
                aturBiaya();

                if (kegiatan.gambar) {
                    $('#previewGambar img').attr(
                        'src',
                        config.urlGambar + encodeURIComponent(kegiatan.gambar)
                    );
                    $('#previewGambar').removeClass('d-none');
                }

                modal.show();
            },

            error: function (xhr) {
                tampilkanPesan(
                    xhr.responseJSON?.message || 'Gagal mengambil data kegiatan.',
                    'danger'
                );
            }
        });
    });

    // ================= VALIDASI =================
    function tampilkanError(errors) {
        $('#daftarError').empty();
        $.each(errors, function (field, message) {
            $('#daftarError').append($('<li>').text(message));
        });
        $('#pesanValidasi').removeClass('d-none');
    }

    // ================= NOTIFIKASI =================
    function tampilkanPesan(pesan, jenis = 'success') {
        const alert = $(`
            <div class="alert alert-${jenis} alert-dismissible fade show" role="alert">
                <span></span>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);
        alert.find('span').text(pesan);
        $('#notifikasiKegiatan').empty().append(alert);
    }

    // ================= SUBMIT AJAX =================
    form.on('submit', function (e) {
        e.preventDefault();

        if (!form[0].checkValidity()) {
            form[0].reportValidity();
            return;
        }

        const formData = new FormData(this);

        // Kirim angka murni — titik ribuan hanya tampilan
        if ($('#jenisBiaya').val() === 'gratis') {
            formData.set('biaya_pendaftaran', '0');
        } else {
            formData.set('biaya_pendaftaran', cleanRibuan(biayaInput.val()));
        }

        $('#pesanValidasi').addClass('d-none');
        $('#daftarError').empty();

        tombolSimpan.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1"></span>
            Menyimpan...
        `);

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',

            success: function (response) {
                if (!response.status) {
                    tampilkanPesan(
                        response.message || 'Gagal menyimpan kegiatan.',
                        'danger'
                    );
                    return;
                }

                modal.hide();
                $('#daftarKegiatan').load(
                    window.location.href + ' #daftarKegiatan > *',
                    function () {
                        tampilkanPesan(response.message, 'success');
                    }
                );
                resetForm();
            },

            error: function (xhr) {
                const response = xhr.responseJSON;
                if (response?.errors) {
                    tampilkanError(response.errors);
                    return;
                }
                tampilkanPesan(
                    response?.message || 'Terjadi kesalahan saat menyimpan kegiatan.',
                    'danger'
                );
            },

            complete: function () {
                tombolSimpan.prop('disabled', false).html(
                    modeForm === 'edit'
                        ? '<i class="bi bi-save me-1"></i> Simpan Perubahan'
                        : '<i class="bi bi-save me-1"></i> Simpan Kegiatan'
                );
            }
        });
    });

    // ================= RESET KETIKA MODAL DITUTUP =================
    modalElement.addEventListener('hidden.bs.modal', function () {
        resetForm();
    });
});