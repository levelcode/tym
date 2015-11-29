<?php session_start();
if(isset($_SESSION["id_user"])){
	header("Location:inicio");
}
	//echo print_r($_SESSION);
# constantes
define('_TITULO', 'Cartecrudo');
define('_INC', 'recursos/inc/');

# autocarga de clases
function cargarClases($clase){
	$clase = strtolower($clase);
	require_once('recursos/php/'.$clase.'.php');
}

spl_autoload_register('cargarClases');
?>
