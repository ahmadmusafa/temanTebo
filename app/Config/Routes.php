<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// PUBLIK
$routes->get('/', 'Home::index');
$routes->get('tentang-kami', 'Home::tentangKami');

$routes->get('kegiatan', 'Kegiatan::index');
$routes->get('kegiatan/gambar/(:segment)', 'Kegiatan::gambar/$1');

$routes->post('kritiksaran/kirim', 'KritikSaran::kirim');

// AUTH
service('auth')->routes($routes, ['except' => ['login', 'logout']]);
$routes->get('login', 'Auth\LoginController::loginView', ['as' => 'login']);
$routes->post('login', '\CodeIgniter\Shield\Controllers\LoginController::loginAction');
$routes->post('logout', '\CodeIgniter\Shield\Controllers\LoginController::logoutAction', ['as' => 'logout']);

// SUPERADMIN
$routes->group('superadmin', ['filter' => ['session', 'group:superadmin']], static function ($routes) {
    $routes->get('/', 'Superadmin::index');

    // Kegiatan
    $routes->get('kegiatan', 'Superadmin\Kegiatan::index');
    $routes->get('kegiatan/tambah', 'Superadmin\Kegiatan::create');
    $routes->post('kegiatan/simpan', 'Superadmin\Kegiatan::store');
    $routes->get('kegiatan/data/(:num)', 'Superadmin\Kegiatan::data/$1');
    $routes->get('kegiatan/edit/(:num)', 'Superadmin\Kegiatan::edit/$1');
    $routes->post('kegiatan/update/(:num)', 'Superadmin\Kegiatan::update/$1');
    $routes->post('kegiatan/hapus/(:num)', 'Superadmin\Kegiatan::delete/$1');

    // Pendaftaran
    $routes->get('pendaftaran', 'Superadmin\Pendaftaran::index');
    $routes->get('pendaftaran/detail/(:num)', 'Superadmin\Pendaftaran::detail/$1');
    $routes->post('pendaftaran/status/(:num)', 'Superadmin\Pendaftaran::updateStatus/$1');
    $routes->post('pendaftaran/pembayaran/(:num)', 'Superadmin\Pendaftaran::updatePembayaran/$1');

    // Statistik
    $routes->get('statistik', 'Superadmin\Statistik::index');
    $routes->post('statistik/update', 'Superadmin\Statistik::update');

    // Kritik & Saran
    $routes->get('kritiksaran', 'Superadmin\KritikSaran::index');
    $routes->post('kritiksaran', 'Superadmin\KritikSaran::index');
    $routes->post('kritiksaran/hapus/(:num)', 'Superadmin\KritikSaran::hapus/$1');
});