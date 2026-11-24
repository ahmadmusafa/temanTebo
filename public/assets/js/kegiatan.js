
$(function () {

    const detailModalElement = document.getElementById('detailModal');
    const pendaftaranModalElement = document.getElementById('pendaftaranModal');

    const detailModal = new bootstrap.Modal(detailModalElement);
    const pendaftaranModal = new bootstrap.Modal(pendaftaranModalElement);

    let dipilih = null;

    // ================= FORMAT RUPIAH =================
    function formatRupiah(nominal) {
        const angka = Number(nominal) || 0;

        return 'Rp' + angka.toLocaleString('id-ID');
    }

    // ================= FORMAT TANGGAL =================
    function formatTanggal(tanggal) {
        if (!tanggal) return '-';

        return new Intl.DateTimeFormat('id-ID', {
            day: 'numeric',
            month: 'long',
            year: 'numeric'
        }).format(new Date(tanggal + 'T00:00:00'));
    }

    // ================= AMBIL DATA KEGIATAN =================
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
            jenisBiaya: d.jenisBiaya,
            nominal: d.nominal,
            gambar: d.gambar,
            maps: d.maps,
            dibuka: d.dibuka === '1'
        };
    }

    // ================= DETAIL KEGIATAN =================
    function bukaDetail(kegiatan) {
        dipilih = kegiatan;

        $('#detailJudul').text(kegiatan.judul);
        $('#detailKategori').text(kegiatan.kategori);
        $('#detailDeskripsi').text(kegiatan.deskripsi);
        $('#detailTanggal').text(formatTanggal(kegiatan.tanggal));
        $('#detailJam').text(kegiatan.jam);
        $('#detailLokasi').text(kegiatan.lokasi);
        $('#detailKuota').text(kegiatan.kuota);
        $('#detailBiaya').text(kegiatan.biaya);
        $('#detailMaps').attr('href', kegiatan.maps);

        if (kegiatan.gambar) {
            $('#detailGambar').attr('src', kegiatan.gambar).show();
        } else {
            $('#detailGambar').hide();
        }

        $('#detailStatus')
            .text(kegiatan.dibuka ? 'Tersedia' : 'Di Tutup')
            .removeClass('text-bg-success text-bg-secondary')
            .addClass(kegiatan.dibuka ? 'text-bg-success' : 'text-bg-secondary');

        $('#detailDaftar').prop('disabled', !kegiatan.dibuka);

        detailModal.show();
    }

    // ================= FORM PENDAFTARAN =================
    function bukaPendaftaran(kegiatan) {
        if (!kegiatan || !kegiatan.dibuka) return;

        dipilih = kegiatan;

        const form = $('#formPendaftaran')[0];

        form.reset();
        $('#pendaftaranAlert').empty();

        $('#formIdKegiatan').val(kegiatan.id);
        $('#formJudulKegiatan').text(kegiatan.judul);

        const berbayar = kegiatan.jenisBiaya === 'berbayar';

        // Tampilkan pembayaran hanya untuk kegiatan berbayar
        $('#bagianPembayaran').toggle(berbayar);

        if (berbayar) {
            const nominal = Number(kegiatan.nominal) || 0;

            // Nominal asli untuk dikirim ke server
            $('#jumlahPembayaran').val(nominal);

            // Nominal dengan format Rupiah untuk peserta
            $('#jumlahPembayaranTampil').val(formatRupiah(nominal));
        } else {
            $('#jumlahPembayaran').val('');
            $('#jumlahPembayaranTampil').val('');
        }

        $('#buktiPembayaran').prop('required', berbayar);

        $('#btnKirimPendaftaran')
            .prop('disabled', false)
            .text('Kirim Pendaftaran');

        detailModal.hide();

        detailModalElement.addEventListener('hidden.bs.modal', function bukaModalPendaftaran() {
            pendaftaranModal.show();

            detailModalElement.removeEventListener(
                'hidden.bs.modal',
                bukaModalPendaftaran
            );
        }, { once: true });

        if (!detailModalElement.classList.contains('show')) {
            pendaftaranModal.show();
        }
    }

    // ================= KLIK KARTU =================
    $('.event-card').on('click', function (e) {
        if ($(e.target).closest('a, button').length) return;

        bukaDetail(ambilData(this));
    });

    // ================= TOMBOL DETAIL =================
    $('.btn-detail').on('click', function (e) {
        e.stopPropagation();

        bukaDetail(ambilData($(this).closest('.event-card')[0]));
    });

    // ================= TOMBOL DAFTAR =================
    $('.btn-daftar').on('click', function (e) {
        e.stopPropagation();

        bukaPendaftaran(ambilData($(this).closest('.event-card')[0]));
    });

    // ================= KEYBOARD =================
    $('.event-card').on('keydown', function (e) {
        if (e.target !== this) return;

        if (e.key === 'Enter' || e.key === ' ') {
            e.preventDefault();
            bukaDetail(ambilData(this));
        }
    });

    // ================= DAFTAR DARI DETAIL =================
    $('#detailDaftar').on('click', function () {
        if (!dipilih || !dipilih.dibuka) return;

        bukaPendaftaran(dipilih);
    });

    // ================= KIRIM PENDAFTARAN =================
    $('#formPendaftaran').on('submit', function (e) {
        e.preventDefault();

        const form = this;
        const tombol = $('#btnKirimPendaftaran');
        const config = window.pendaftaranConfig;

        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        tombol.prop('disabled', true).text('Mengirim...');

        const formData = new FormData(form);

        formData.set(config.csrfName, config.csrfHash);

        $.ajax({
            url: config.urlSimpan,
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            dataType: 'json',

            success: function (response) {
                if (response.csrfHash) {
                    config.csrfHash = response.csrfHash;
                }

                if (response.status) {
                    $('#pendaftaranAlert').html(
                        '<div class="alert alert-success">' +
                        response.message +
                        '</div>'
                    );

                    form.reset();

                    setTimeout(function () {
                        pendaftaranModal.hide();
                        $('#pendaftaranAlert').empty();
                    }, 1800);

                    return;
                }

                $('#pendaftaranAlert').html(
                    '<div class="alert alert-danger">' +
                    response.message +
                    '</div>'
                );

                tombol.prop('disabled', false).text('Kirim Pendaftaran');
            },

            error: function (xhr) {
                const response = xhr.responseJSON || {};

                if (response.csrfHash) {
                    config.csrfHash = response.csrfHash;
                }

                $('#pendaftaranAlert').html(
                    '<div class="alert alert-danger">' +
                    (response.message || 'Terjadi kesalahan. Silakan coba kembali.') +
                    '</div>'
                );

                tombol.prop('disabled', false).text('Kirim Pendaftaran');
            }
        });
    });

});
