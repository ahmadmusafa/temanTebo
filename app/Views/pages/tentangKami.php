<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<link rel="stylesheet" href="<?= base_url('assets/css/tentangKami.css') ?>">

<div class="about-page">

    <!-- HERO -->
    <section class="about-hero">
        <div class="container">
            <div class="row align-items-center g-5">

                <div class="col-lg-6 reveal">
                    <h1 class="hero-title mb-4">
                        Muda, Berdaya,
                        <span class="text-orange">Berdampak.</span>
                    </h1>

                    <p class="hero-description mb-4">
                        Ruang bagi generasi muda untuk bergerak bersama,
                        mengembangkan potensi, dan menciptakan perubahan
                        positif bagi masyarakat.
                    </p>

                    <a href="<?= base_url('kegiatan') ?>" class="btn-orange">
                        Temukan Kegiatan
                        <i class="bi bi-arrow-up-right"></i>
                    </a>

                    <div class="d-flex align-items-center gap-2 mt-4 pt-2">
                        <i class="bi bi-heart-fill text-orange"></i>
                        <span class="text-secondary small">
                            Berawal dari kepedulian, tumbuh melalui kolaborasi.
                        </span>
                    </div>
                </div>

                <div class="col-lg-6 reveal delay-1">
                    <div class="hero-image-wrap">
                        <img
                            src="<?= base_url('assets/img/kegiatan1.JPG') ?>"
                            alt="Kegiatan sosial TemanTebo"
                            class="hero-image"
                        >

                        <div class="hero-floating">
                            <div>
                                <div class="fw-bold">Bergerak Bersama</div>
                                <small class="text-secondary">
                                    Ciptakan dampak positif
                                </small>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- VISI DAN MISI -->
    <section class="about-section">
        <div class="container">

            <div class="text-center mb-5 reveal">
                <span class="section-label">APA YANG KAMI PERCAYAI</span>

                <h2 class="section-title mt-3 mb-3">
                    Bertumbuh dengan Tujuan
                </h2>

                <p class="section-description">
                    Kami percaya perubahan dimulai ketika anak muda
                    memiliki ruang untuk peduli, belajar, dan mengambil aksi.
                </p>
            </div>

            <div class="row g-4">

                <div class="col-md-6 reveal">
                    <div class="value-card">
                        <div class="value-icon mb-4">
                            <i class="bi bi-lightbulb"></i>
                        </div>

                        <h4 class="fw-bold mb-3">Visi Kami</h4>

                        <p class="mb-0">
                            Menjadi ruang kolaborasi anak muda yang inspiratif,
                            inklusif, dan berkelanjutan untuk menciptakan
                            perubahan positif di masyarakat.
                        </p>
                    </div>
                </div>

                <div class="col-md-6 reveal delay-1">
                    <div class="value-card">
                        <div class="value-icon mb-4">
                            <i class="bi bi-rocket-takeoff"></i>
                        </div>

                        <h4 class="fw-bold mb-3">Misi Kami</h4>

                        <p class="mb-0">
                            Mendorong partisipasi generasi muda melalui
                            kegiatan sosial, pengembangan kapasitas,
                            dan kolaborasi lintas komunitas.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- FOUNDER -->
    <section class="about-section founder-section" id="tentang-founder">
        <div class="container">
            <div class="row align-items-center justify-content-center g-5">

                <div class="col-md-5 col-lg-4 reveal">
                    <div class="founder-photo-wrap">
                        <img
                            src="<?= base_url('assets/img/kegiatan2.JPG') ?>"
                            alt="Founder TemanTebo"
                            class="founder-photo"
                        >
                    </div>
                </div>

                <div class="col-md-7 col-lg-6 reveal delay-1">
                    <span class="section-label">PESAN DARI FOUNDER</span>

                    <div class="quote-mark mt-3">
                        <i class="bi bi-quote"></i>
                    </div>

                    <h2 class="section-title mb-4">
                        Perubahan Besar Dimulai dari Langkah Kecil.
                    </h2>

                    <p class="founder-quote">
                        Saya percaya setiap anak muda memiliki potensi
                        untuk membawa perubahan. Kita tidak harus menunggu
                        menjadi hebat untuk mulai berbuat baik.
                    </p>

                    <p class="founder-quote">
                        Melalui TemanTebo, saya berharap kita bisa membangun
                        ruang untuk saling belajar, berkolaborasi, dan
                        menghadirkan manfaat nyata bagi masyarakat.
                        Mari bergerak bersama, dimulai dari hal sederhana
                        yang bisa kita lakukan hari ini.
                    </p>

                    <div class="border-top pt-3 mt-4">
                        <h5 class="fw-bold mb-1">Dewi Ulfa Uluwiyah, S.H</h5>
                        <p class="text-secondary mb-0">Founder TemanTebo dan DPRD Kab.Tebo</p>
                    </div>
                </div>

            </div>
        </div>
    </section>

</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const elements = document.querySelectorAll('.reveal');

        if (!('IntersectionObserver' in window)) {
            elements.forEach(function (element) {
                element.classList.add('show');
            });

            return;
        }

        const observer = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('show');
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.12
        });

        elements.forEach(function (element) {
            observer.observe(element);
        });
    });
</script>

<?= $this->endSection() ?>