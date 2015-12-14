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

			<section id="fotos">
				<div class="container">
					<div class="row">
						<div class="col-xs-12 text-center">
							<h1 class="c-color3 text-uppercase">Car Audio <small>2012</small></h1>
							<br>
						</div>
						<div class="col-xs-12">
							<div class="clearfix" class="text-center">
								<ul id="image-gallery" class="gallery list-unstyled cS-hidden">
				                    <li data-thumb="recursos/img/thumb/foto-carro-01.jpg"> 
				                        <img src="recursos/img/foto-carro-01.jpg" class="img-responsive">
				                    </li>
				                    <li data-thumb="recursos/img/thumb/foto-carro-02.jpg"> 
				                        <img src="recursos/img/foto-carro-02.jpg" class="img-responsive">
				                    </li>
				                    <li data-thumb="recursos/img/thumb/foto-carro-03.jpg"> 
				                        <img src="recursos/img/foto-carro-03.jpg" class="img-responsive">
				                    </li>
				                    <li data-thumb="recursos/img/thumb/foto-carro-04.jpg"> 
				                        <img src="recursos/img/foto-carro-04.jpg" class="img-responsive">
				                    </li>
				                    <li data-thumb="recursos/img/thumb/foto-carro-05.jpg"> 
				                        <img src="recursos/img/foto-carro-05.jpg" class="img-responsive">
				                    </li>
				                    <li data-thumb="recursos/img/thumb/foto-carro-06.jpg"> 
				                        <img src="recursos/img/foto-carro-06.jpg" class="img-responsive">
				                    </li>
				                    <li data-thumb="recursos/img/thumb/foto-carro-07.jpg"> 
				                        <img src="recursos/img/foto-carro-07.jpg" class="img-responsive">
				                    </li>
				                    <li data-thumb="recursos/img/thumb/foto-carro-08.jpg"> 
				                        <img src="recursos/img/foto-carro-08.jpg" class="img-responsive">
				                    </li>
				                    <li data-thumb="recursos/img/thumb/foto-carro-09.jpg"> 
				                        <img src="recursos/img/foto-carro-09.jpg" class="img-responsive">
				                    </li>
				                    <li data-thumb="recursos/img/thumb/foto-carro-10.jpg"> 
				                        <img src="recursos/img/foto-carro-10.jpg" class="img-responsive">
				                    </li>
				                </ul>
				            </div>
						</div>
					</div>
					<hr>
					<div class="row">
						<div class="col-xs-12 text-center">
							<a href="./galerias" class="btn bg-color3 c-blanco text-uppercase txt-16"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;Volver a Galerías</a>
						</div>
					</div>
				</div>
			</section>
		</div>
<!-- Pie de página -->
<?php

$opciones = array(
	'js' => array(
		'recursos/js/lightslider.js',
		'recursos/js/galerias.js'
	)
);

$pie = new html\Pie($opciones);

?>
