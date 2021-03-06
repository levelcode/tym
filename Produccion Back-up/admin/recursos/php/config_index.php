<?php 
session_start();

if(isset($_SESSION["id"])){
	header("Location: ./inicio");
}

# constantes
define('_TITULO', 'TYM Accesorios');
define('_INC', 'recursos/inc/');

# autocarga de clases de datos
function cargarClase($clase){

	$clase = strtolower($clase);
	$clase = str_replace('\\', '/', $clase);

	include_once('recursos/php/'.$clase.'.php');
}

spl_autoload_register('cargarClase');

