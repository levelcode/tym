<?php 
namespace html;

class Cabecero extends a_Html
{
	protected $titulo;
	protected $css;
	protected $cabecero;

	public function __construct(array $opciones){
		isset($opciones['titulo']) && gettype($opciones['titulo']) == 'string' ? $this->titulo = $opciones['titulo'] : $this->titulo = _TITULO;
		$this->cabecero = isset($opciones['cabecero']) && gettype($opciones['cabecero']) == 'string' ? $opciones['cabecero'] : 'cabecero-general';
		if(isset($opciones['css']) && gettype($opciones['css']) == 'array') $this->ConstruirCss($opciones['css']);
		parent::__construct($opciones);
	}

	private function construirCss(array $opcion){
		$html = '';
		foreach($opcion as $script){
			$html .= "\t\t<link rel=\"stylesheet\" href=\"{$script}\" />\n";
		}
		$this->css = $html;
	}

	protected function construirHtml(){
		ob_start();
?>
<!DOCTYPE html>
<html lang="en" ng-app="adminTymApp">
	<head>
		<meta charset="UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php $this->obtener('titulo') ?></title>
		<link rel="icon" href="recursos/img/favicon.png">
		<link rel="stylesheet" href="recursos/css/bootstrap.css">
		<link rel="stylesheet" href="recursos/css/font-awesome.css">
		<!-- <link rel="stylesheet" href="recursos/css/eventi-iconos.css">  -->
		<link rel="stylesheet" href="recursos/css/general.css">
		<?php $this->obtener('css') ?>
		<script src="recursos/js/jquery.js"></script>
		<script src="recursos/js/jquery-ui.js"></script>
		<?php $this->obtener('js') ?>
	</head>
	<body>
		<!-- <div id="preloader">
			<div class="contenido">
				<img src="recursos/img/preloader.gif" alt="">
			</div>
		</div> -->
		<!-- conexion de internet -->
		<section id="conexion-internet">
			<div class="contenido"></div>
		</section>
		<!-- preloader -->
		<div id="preloader">
			<div class="cont">
				<img src="recursos/img/preloader.gif" alt="">
			</div>
		</div>
<?php
		require_once(_INC."{$this->cabecero}.php");
		$this->html = ob_get_contents();
		ob_clean();
	}
}

?>