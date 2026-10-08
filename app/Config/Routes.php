<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Login::index');
$routes->post('login', 'Login::login_action');
$routes->get('Admin/home', 'Admin\Home::index');
$routes->get('Pegawai/home', 'Pegawai\Home::index');
