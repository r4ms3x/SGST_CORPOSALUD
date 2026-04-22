<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index'); // Tu dashboard o inicio
$routes->get('registro', 'Auth::registroAdmin');
$routes->get('login', 'Auth::login');
$routes->get('admin/inicio', 'AdminController::index');
