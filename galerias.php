<!-- Cabecero -->
<?php
require_once('recursos/php/config.php');

$opciones = array(
	'responsivo' => true,
	'descripcion' => 'La descripción aquí',
	'autor' => 'prograCOL - http://progracol.com',
	'titulo' => 'Galerías - '._TITULO,
	'css' => array(
		'recursos/css/galerias.css',
		'recursos/css/lightslider.css',
	),
	'js' => array()
);

$cabecero = new html\Cabecero($opciones);


?>

<!-- contenido -->
		<div id="contenido">
			<div id="titulo">
				<h1 class="text-uppercase">Galería</h1>
			</div>

			<section id="galeria">
				<div class="container">
					<div class="row">
						<div class="col-sm-4">
							<div class="galeria">
								<img src="recursos/img/foto-galeria-1.jpg" alt="" class="img-responsive">
								<a href="./fotos" class="titulo">
									<i class="fa fa-search fa-3x c-color1"></i><br>
									<span class="txt-26">Car Audio</span><br>
									<span class="txt-18 c-color1">2012</span>
								</a>
							</div>
							<div class="galeria">
								<img src="recursos/img/foto-galeria-2.jpg" alt="" class="img-responsive">
								<a href="./fotos" class="titulo">
									<i class="fa fa-search fa-3x c-color1"></i><br>
									<span class="txt-26">Galería 1</span><br>
									<span class="txt-18 c-color1">2015</span>
								</a>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="galeria">
								<img src="recursos/img/foto-galeria-3.jpg" alt="" class="img-responsive">
								<a href="./fotos" class="titulo">
									<i class="fa fa-search fa-3x c-color1"></i><br>
									<span class="txt-26">Galería 2</span><br>
									<span class="txt-18 c-color1">2015</span>
								</a>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="galeria">
								<img src="recursos/img/foto-galeria-4.jpg" alt="" class="img-responsive">
								<a href="./fotos" class="titulo">
									<i class="fa fa-search fa-3x c-color1"></i><br>
									<span class="txt-26">Galería 3</span><br>
									<span class="txt-18 c-color1">2015</span>
								</a>
							</div>
							<div class="galeria">
								<img src="recursos/img/foto-galeria-5.jpg" alt="" class="img-responsive">
								<a href="./fotos" class="titulo">
									<i class="fa fa-search fa-3x c-color1"></i><br>
									<span class="txt-26">Galería 4</span><br>
									<span class="txt-18 c-color1">2015</span>
								</a>
							</div>
						</div>
					</div>
				</div>
			</section>
		</div>
<!-- Pie de página -->
<?php

$opciones = array(
	'js' => array(
		'recursos/js/galerias.js'
	)
);

$pie = new html\Pie($opciones);

?>
