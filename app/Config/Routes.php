<?php

namespace Config;

use CodeIgniter\Router\RouteCollection;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

/*
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
// The Auto Routing (Legacy) is very dangerous. It is easy to create vulnerable apps
// where controller filters or CSRF protection are bypassed.
// If you don't want to define all routes, please use the Auto Routing (Improved).
// Set `$autoRoutesImproved` to true in `app/Config/Feature.php` and set the following to true.
// $routes->setAutoRoute(false);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

$routes->get('/', 'Home::index');

$routes->get('/Guia', 'Guia::index');

$routes->get('/Liquidacion', 'Liquidacion::index');
$routes->post('/Recepcion/registrarTemp', 'Guia::registrartemp');
$routes->get('/Recepcion/obtenerDatos', 'Guia::obtenerTodosLosDatos');
$routes->post('/Recepcion/eliminar/(:any)', 'Guia::eliminar/$1');
$routes->get('/Recepcion/transferir', 'Guia::transferirDatos');



