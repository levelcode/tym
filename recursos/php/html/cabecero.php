<?php
namespace html;


class Cabecero extends a_Html
{
	protected $titulo;
	protected $css;
	protected $cabecero;
	protected $is_admin;
	protected $no_cabecero;

	public function __construct(array $opciones){
		isset($opciones['titulo']) && gettype($opciones['titulo']) == 'string' ? $this->titulo = $opciones['titulo'] : $this->titulo = _TITULO;

		$this->cabecero = isset($opciones['cabecero']) && gettype($opciones['cabecero']) == 'string' ? $opciones['cabecero'] : 'cabecero-general';

		$this->no_cabecero = (isset($opciones['cabecero']) && (gettype($opciones['cabecero']) == 'string' && ($opciones['cabecero'] == 'no-cabecero'))) ? true : false;

		$this->is_admin = ( isset($opciones['is_admin']) && $opciones['is_admin'] )  ? $this->is_admin = $opciones['is_admin'] : false;

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
<html lang="es" ng-app="tymApp" ng-csp>
	<head>
		<meta charset="UTF-8" >
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title><?php $this->obtener('titulo') ?></title>
		<link rel="icon" href="recursos/img/favicon.png">
		<link rel="stylesheet" href="recursos/css/bootstrap.css">
		<link rel="stylesheet" href="recursos/css/font-awesome.css">
		<link rel="stylesheet" href="recursos/css/lightslider.css">
		<!-- <link rel="stylesheet" href="recursos/css/eventi-iconos.css">  -->
		<?php if( $this->is_admin ): ?>
			<link rel="stylesheet" href="recursos/css/admin/general.css">
		<?php endif;?>
		<link rel="stylesheet" href="recursos/css/general.css">
		<link rel="stylesheet" href="recursos/css/extra.css">
		<link rel="stylesheet" href="recursos/css/tooltip.css">
		<?php $this->obtener('css') ?>
		<script src="recursos/js/jquery.js"></script>
		<?php $this->obtener('js') ?>
	</head>
	<body>
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

		<!-- Elemento de javascript desactivado -->
		<noscript>
			<div class="container">
				<div class="row">
					<div class="col-xs-12 text-center">
						<img src="recursos/img/logo.png" alt="logotipo"><br>
						<h1>JavaScript está desactivado</h1>
						<p class="txt-18">Esta aplicación solo funciona con javascript activado, por favor activalo en tu navegador para eliminar este mensaje y usar el sitio</p>
					</div>
				</div>
			</div>
		</noscript>
<?php
		if( !$this->no_cabecero ){
			if( $this->is_admin ) {
				require_once(_INC_ADMIN."{$this->cabecero}.php");
			}else {
				require_once(_INC."{$this->cabecero}.php");
			}

		}

		$this->html = ob_get_contents();
		ob_clean();
	}
}

?>
