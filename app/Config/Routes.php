<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/Guia', 'Guia::index');

$routes->get('/Liquidacion', 'Liquidacion::index');
$routes->post('/Recepcion/registrarTemp', 'Guia::registrartemp');
$routes->get('/Recepcion/obtenerDatos', 'Guia::obtenerTodosLosDatos');
$routes->post('/Recepcion/eliminar/(:any)', 'Guia::eliminar/$1');
$routes->get('/Recepcion/transferir', 'Guia::transferirDatos');




