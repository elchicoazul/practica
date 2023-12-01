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

// rutas  braulio
$routes->get('/Usuarios', 'Usuarios::usuario');
$routes->get('/Productos', 'Productos::producto');
$routes->get('/Configuracion', 'Configuraciones::configuracion');
$routes->get('/Servicio', 'Servicios::servicio');

$routes->post('/Productos/registrar', 'Productos::registrar');
$routes->post('/Configuraciones/registrar', 'Configuraciones::registrar');
$routes->post('/Servicios/registrar', 'Servicios::registrar');
$routes->post('/Usuarios/registrar', 'Usuarios::registrar');


