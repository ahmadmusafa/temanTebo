<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// HALAMAN PUBLIK
$routes->get('/', 'Home::index');
$routes->get('tentang-kami', 'Home::tentangKami');
$routes->get('kegiatan', 'Home::kegiatan');
$routes->get('kegiatan/gambar/(:segment)', 'Home::gambar/$1');

// AUTENTIKASI SHIELD
service('auth')->routes($routes, [
    'except' => ['login', 'logout'],
]);

// LOGIN
$routes->get('login', 'Auth\LoginController::loginView', [
    'as' => 'login',
]);

$routes->post(
    'login',
    '\CodeIgniter\Shield\Controllers\LoginController::loginAction'
);

// LOGOUT
$routes->post(
    'logout',
    '\CodeIgniter\Shield\Controllers\LoginController::logoutAction',
    ['as' => 'logout']
);

// DASHBOARD SUPERADMIN
$routes->group('superadmin', [
    'filter' => ['session', 'group:superadmin'],
], static function ($routes) {

    // DASHBOARD
    $routes->get('/', 'Superadmin::index');

    // KEGIATAN
    $routes->get('kegiatan', 'Superadmin\Kegiatan::index');
    $routes->get('kegiatan/tambah', 'Superadmin\Kegiatan::create');
    $routes->post('kegiatan/simpan', 'Superadmin\Kegiatan::store');
    $routes->get('kegiatan/data/(:num)', 'Superadmin\Kegiatan::data/$1');
    $routes->get('kegiatan/edit/(:num)', 'Superadmin\Kegiatan::edit/$1');
    $routes->post('kegiatan/update/(:num)', 'Superadmin\Kegiatan::update/$1');
    $routes->post('kegiatan/hapus/(:num)', 'Superadmin\Kegiatan::delete/$1');

    // PENDAFTARAN
    $routes->get('pendaftaran', 'Superadmin\Pendaftaran::index');
    $routes->get('pendaftaran/detail/(:num)', 'Superadmin\Pendaftaran::detail/$1');
    $routes->post('pendaftaran/status/(:num)', 'Superadmin\Pendaftaran::updateStatus/$1');
    $routes->post('pendaftaran/pembayaran/(:num)', 'Superadmin\Pendaftaran::updatePembayaran/$1');

    // STATISTIK
    $routes->group('statistik', static function ($routes) {
        $routes->get('/', 'Superadmin\Statistik::index');
        $routes->post('update', 'Superadmin\Statistik::update');
    });
});
