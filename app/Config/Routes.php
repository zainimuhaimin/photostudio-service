<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'LoginController::index', ['filter' => 'noAuth']);
$routes->get('/register', 'RegistrationController::index', ['filter' => 'noAuth']);
$routes->post('/registration/save', 'RegistrationController::save', ['filter' => 'noAuth']);
$routes->get('/login', 'LoginController::index', ['filter' => 'noAuth']);
$routes->post('/authenticate', 'LoginController::authenticate', ['filter' => 'noAuth']);

$routes->get('/dashboard', 'DashboardController::index', ['filter' => 'auth']);
$routes->get('/logout', 'LoginController::logout', ['filter' => 'auth']);

$routes->get('/pelanggan-table', 'PelangganController::index', ['filter' => 'auth']);
$routes->get('/pelanggan-add', 'PelangganController::add', ['filter' => 'auth']);
$routes->post('/pelanggan-save', 'PelangganController::save', ['filter' => 'auth']);
$routes->delete('/pelanggan-delete/(:num)', 'PelangganController::delete/$1', ['filter' => 'auth']);
$routes->get('/pelanggan-edit/(:num)', 'PelangganController::edit/$1', ['filter' => 'auth']);
$routes->post('/pelanggan-update', 'PelangganController::update', ['filter' => 'auth']);

$routes->get('/alat-table', 'AlatController::index', ['filter' => 'auth']);
$routes->get('/alat-add', 'AlatController::add', ['filter' => 'auth']);
$routes->post('/alat-save', 'AlatController::save', ['filter' => 'auth']);
$routes->get('/alat/get-image/(:num)', 'AlatController::getImage/$1', ['filter' => 'auth']);
$routes->get('/alat/pelanggan-get-transaction-data/(:num)', 'AlatController::getAlatByIdJoinTransaction/$1', ['filter' => 'auth']);
$routes->delete('/alat-delete/(:num)', 'AlatController::delete/$1', ['filter' => 'auth']);
$routes->get('/alat-edit/(:num)', 'AlatController::edit/$1', ['filter' => 'auth']);
$routes->post('/alat-update', 'AlatController::update', ['filter' => 'auth']);

$routes->get('/jasa-table', 'JasaController::index', ['filter' => 'auth']);
$routes->get('/jasa-add', 'JasaController::add', ['filter' => 'auth']);
$routes->post('/jasa-save', 'JasaController::save', ['filter' => 'auth']);
$routes->get('/jasa/pelanggan-get-transaction-data/(:num)', 'JasaController::getJasaByIdJoinTransaction/$1', ['filter' => 'auth']);
$routes->delete('/jasa-delete/(:num)', 'JasaController::delete/$1', ['filter' => 'auth']);
$routes->get('/jasa-edit/(:num)', 'JasaController::edit/$1', ['filter' => 'auth']);
$routes->post('/jasa-update', 'JasaController::update', ['filter' => 'auth']);

$routes->get('/penyewaan-table', 'PenyewaanAlatController::index', ['filter' => 'auth']);
$routes->get('/penyewaan-add', 'PenyewaanAlatController::add', ['filter' => 'auth']);
$routes->post('/penyewaan-save', 'PenyewaanAlatController::save', ['filter' => 'auth']);
$routes->post('/penyewaan/get-jadwal', 'PenyewaanAlatController::getJadwal', ['filter' => 'auth']);
$routes->get('/penyewaan-edit/(:num)', 'PenyewaanAlatController::edit/$1', ['filter' => 'auth']);
$routes->post('/penyewaan-update', 'PenyewaanAlatController::update', ['filter' => 'auth']);

$routes->get('/pemesanan-table', 'PemesananJasaController::index', ['filter' => 'auth']);
$routes->get('/pemesanan-add', 'PemesananJasaController::add', ['filter' => 'auth']);
$routes->post('/pemesanan-save', 'PemesananJasaController::save', ['filter' => 'auth']);
$routes->post('/pemesanan/get-jadwal', 'PemesananJasaController::getJadwal', ['filter' => 'auth']);
$routes->get('/pemesanan-edit/(:num)', 'PemesananJasaController::edit/$1', ['filter' => 'auth']);
$routes->post('/pemesanan-update', 'PemesananJasaController::update', ['filter' => 'auth']);

$routes->get('/pembayaran-table', 'PembayaranController::index', ['filter' => 'auth']);
$routes->get('/pembayaran-detail/(:num)', 'PembayaranController::detail/$1', ['filter' => 'auth']);
$routes->post('/pembayaran-update', 'PembayaranController::update', ['filter' => 'auth']);
$routes->get('/pembayaran-receipt/(:num)', 'PembayaranController::invoice/$1', ['filter' => 'auth']);
