<?php
error_reporting(0);
$filtros = ['jpg', 'png', 'gif', 'pdf', 'php', 'html', 'doc', 'docx', 'xls', 'xlsx'];

chdir('../../../');

$directorios = ['.', 'recursos/img'];
$resultados = [];

foreach($directorios as $dir){
	foreach (scandir($dir) as $archivo) {
		$archivo = pathinfo($archivo);
		$resultados[] = ['nombre' => $archivo['filename'], 'extension' => $archivo['extension'], 'ruta' => $dir, 'base' => $archivo['basename']];
	}
}

$a = [];

array_walk($resultados, function($b){

	global $filtros, $a;

	foreach($filtros as $filtro){
		//echo $filtro;
		if(strtolower($b['extension']) == $filtro){
			$a[] = $b;
		}
		//echo ( ?  '1' : '0');
	}
});

$a = json_encode($a);

header('Content-Type: application/json');
echo $a;