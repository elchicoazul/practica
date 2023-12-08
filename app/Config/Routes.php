<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/Guia', 'Guia::index');

$routes->get('/Liquidacion', 'Liquidacion::index');
$routes->match(['get', 'post'], '/Liquidacion/buscarDatosCliente/(:any)', 'Liquidacion::buscarDatosCliente/$1');
$routes->post('/Liquidacion/registrarAnalisisTemp', 'Liquidacion::registrarAnalisisTemp');
$routes->get('/Liquidacion/obtenerDatos/(:any)', 'Liquidacion::obtenerTodosLosDatos/$1');
$routes->post('/Liquidacion/actualizarAnalisis/(:any)', 'Liquidacion::actualizarAnalisis/$1');

$routes->post('/Recepcion/registrarTemp', 'Guia::registrartemp');
$routes->get('/Recepcion/obtenerDatos/(:any)', 'Guia::obtenerTodosLosDatos/$1');
$routes->post('/Recepcion/eliminar/(:any)', 'Guia::eliminar/$1');
$routes->match(['get', 'post'], '/Recepcion/transferir', 'Guia::transferirDatos');

// rutas  braulio
$routes->get('/Usuarios', 'Usuarios::usuario');
$routes->get('/Productos', 'Productos::producto');
$routes->get('/Configuracion', 'Configuraciones::configuracion');
$routes->get('/Servicio', 'Servicios::servicio');
$routes->get('/Programacion', 'Programaciones::programacion');
$routes->get('/Productos/obtenerTodos', 'Productos::obtenerTodos');
$routes->match(['get', 'post'], '/Usuarios/ObtenerUsuario', 'Usuarios::ObtenerUsuario');
$routes->match(['get', 'post'], '/Productos/ObtenerProductos', 'Productos::ObtenerProductos');

//ordenar

$routes->post('/Productos/registrar', 'Productos::registrar');
$routes->post('/Configuraciones/registrar', 'Configuraciones::registrar');
$routes->post('/Servicios/registrar', 'Servicios::registrar');
$routes->post('/Usuarios/registrar', 'Usuarios::registrar');



