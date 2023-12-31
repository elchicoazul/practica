<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/Guia', 'Guia::index');

//reportes
$routes->get('/Reportes','Reportes::index');
$routes->match(['get', 'post'],'/Reportes/ReporteGL','Reportes::ReporteGL');

$routes->get('/Liquidacion', 'Liquidacion::index');
$routes->match(['get', 'post'], '/Liquidacion/buscarDatosCliente/(:any)', 'Liquidacion::buscarDatosCliente/$1');
$routes->post('/Liquidacion/registrarAnalisisTemp', 'Liquidacion::registrarAnalisisTemp');
$routes->get('/Liquidacion/obtenerDatos/(:any)', 'Liquidacion::obtenerTodosLosDatos/$1');
$routes->post('/Liquidacion/actualizarAnalisis/(:any)', 'Liquidacion::actualizarAnalisis/$1');
$routes->post('/Liquidacion/obtenerTotalValores', 'Liquidacion::obtenerTotalValores');

$routes->post('/Recepcion/registrarTemp', 'Guia::registrartemp');
$routes->get('/Recepcion/obtenerDatos/(:any)', 'Guia::obtenerTodosLosDatos/$1');
$routes->post('/Recepcion/eliminar/(:any)', 'Guia::eliminar/$1');
$routes->match(['get', 'post'], '/Recepcion/transferir', 'Guia::transferirDatos');



// rutas usuarios
$routes->get('/Usuarios', 'Usuarios::usuario');
$routes->get('/Usuarios/obtenerTodosUsuarios', 'Usuarios::obtenerTodosUsuarios');//listar
$routes->post('/Usuarios/registrar', 'Usuarios::registrar');
$routes->post('/Usuarios/eliminar/(:any)', 'Usuarios::eliminar/$1');
$routes->post('/Usuarios/guardar/(:num)', 'Usuarios::guardar/$1');


// rutas productos
$routes->get('/Productos', 'Productos::producto');
$routes->get('/Productos/obtenerTodos', 'Productos::obtenerTodos');//listar
$routes->post('/Productos/registrar', 'Productos::registrar');
$routes->post('/Productos/eliminar/(:any)', 'Productos::eliminar/$1');
$routes->post('/Productos/guardar/(:num)', 'Productos::guardar/$1');

// rutas servicios
$routes->get('/Servicios', 'Servicios::servicio');
$routes->get('/Servicios/obtenerTodosServicios', 'Servicios::obtenerTodosServicios');//listar
$routes->post('/Servicios/registrar', 'Servicios::registrar');
$routes->post('/Servicios/eliminar/(:any)', 'Servicios::eliminar/$1');
$routes->post('/Servicios/guardar/(:num)', 'Servicios::guardar/$1');

// rutas configuraciones
$routes->get('/Configuraciones', 'Configuraciones::configuracion');
$routes->get('/Configuraciones/obtenerTodasConfiguraciones', 'Configuraciones::obtenerTodasConfiguraciones');//listar
$routes->post('/Configuraciones/registrar', 'Configuraciones::registrar');
$routes->post('/Configuraciones/eliminar/(:any)', 'Configuraciones::eliminar/$1');
$routes->post('/Configuraciones/guardar/(:num)', 'Configuraciones::guardar/$1');


// rutas programaciones
$routes->get('/Programacion', 'Programaciones::programacion');
$routes->post('/Programaciones/registrar', 'Programaciones::registrar');
$routes->match(['get', 'post'], '/Productos/ObtenerProductos', 'Productos::ObtenerProductos');
$routes->match(['get', 'post'], '/Usuarios/ObtenerUsuario', 'Usuarios::ObtenerUsuario');
$routes->get('/Programaciones/obtenerTodasProgramaciones/(:num)', 'Programaciones::obtenerTodasProgramaciones/$1');
$routes->post('/Programaciones/eliminar/(:any)', 'Programaciones::eliminar/$1');

//reportes
$routes->match(['get', 'post'], '/Guia/obtenerGuia', 'Guia::obtenerGuia');





