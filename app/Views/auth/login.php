 
<?= $this->extend('\CodeIgniter\Shield\Views\layout') ?>

<?= $this->section('main') ?>

<div class="container min-vh-100 d-flex align-items-center justify-content-center py-5">
    <div class="w-100" style="max-width: 400px;">

        <div class="text-center mb-4">
            <img
                src="<?= base_url('assets/img/temantebo.png') ?>"
                alt="Logo TemanTebo"
                class="mb-3"
                style="width: 72px; height: 72px; object-fit: contain;"
            >

            <h3 class="fw-bold mb-1">Selamat Datang</h3>
            <p class="text-secondary">Masuk ke akun TemanTebo kamu</p>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-4">

                <?php if (session('error')): ?>
                    <div class="alert alert-danger">
                        <?= esc(session('error')) ?>
                    </div>
                <?php endif ?>

                <?php if (session('errors')): ?>
                    <div class="alert alert-danger">
                        <?php foreach (session('errors') as $error): ?>
                            <div><?= esc($error) ?></div>
                        <?php endforeach ?>
                    </div>
                <?php endif ?>

                <form action="<?= url_to('login') ?>" method="post">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">
                            Email
                        </label>
                        <input
                            type="email"
                            name="email"
                            id="email"
                            class="form-control form-control-lg fs-6 rounded-3"
                            placeholder="nama@email.com"
                            value="<?= esc(old('email') ?? '') ?>"
                            autocomplete="email"
                            required
                            autofocus
                        >
                    </div>

                    <div class="mb-4">
                        <label for="password" class="form-label fw-semibold">
                            Password
                        </label>
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-control form-control-lg fs-6 rounded-3"
                            placeholder="Masukkan password"
                            autocomplete="current-password"
                            required
                        >
                    </div>

                    <button type="submit" class="btn btn-warning btn-lg w-100 rounded-3 fw-semibold">
                        Masuk
                    </button>
                </form>

                <?php if (setting('Auth.allowRegistration')): ?>
                    <p class="text-center text-secondary mt-4 mb-0">
                        Belum punya akun?
                        <a href="<?= url_to('register') ?>" class="text-decoration-none fw-semibold">
                            Daftar
                        </a>
                    </p>
                <?php endif ?>

            </div>
        </div>

        <p class="text-center text-secondary small mt-4">
            &copy; <?= date('Y') ?> TemanTebo
        </p>

    </div>
</div>

<?= $this->endSection() ?>
