<?php

//error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
error_reporting(0);
session_start();

# constantes
define('_TITULO', 'TYM Accesorios');
define('_INC', 'recursos/php/html/inc/');
define('_MODAL', 'recursos/php/html/modal/');
define('_INC_ADMIN', 'recursos/php/html/inc/admin/');

# autocarga de clases de datos
function cargarClase($clase){

	$clase = strtolower($clase);
	$clase = str_replace('\\', '/', $clase);
	include_once('recursos/php/'.$clase.'.php');
}

spl_autoload_register('cargarClase');



?>
