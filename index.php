<!-- Cabecero -->
<?php
require_once('recursos/php/config.php');

$opciones = array(
	'responsivo' => true,
	'descripcion' => 'Progracol es una empresa de ',
	'autor' => 'prograCOL - http://progracol.com',
	'titulo' => _TITULO,
	'css' => array(
		'recursos/css/index.css'
	),
	'js' => array()
);

$cabecero = new html\Cabecero($opciones);


?>

<!-- contenido -->
		<div id="contenido">
			<section id="slider">
				<div class="container no-padding-horizontal">
					<!-- slider inicio -->
					<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
						<!-- Indicators -->
						<ol class="carousel-indicators">
							<li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
							<li data-target="#carousel-example-generic" data-slide-to="1"></li>
							<li data-target="#carousel-example-generic" data-slide-to="2"></li>
						</ol>
						<!-- Wrapper for slides -->
						<div class="carousel-inner" role="listbox">
							<div class="item active">
								<img src="recursos/img/sld-1.jpg" alt="...">
								<div class="carousel-caption">
									<div class="etiqueta">
										<span class="grande">Rines ultralivianos</span><br>
										<span class="pequeño">en <b>aluminio y cromados</b></span>
									</div>
								</div>
							</div>
							<div class="item">
								<img src="recursos/img/sld-2.jpg" alt="...">
								<div class="carousel-caption">
									<div class="etiqueta">
										<span class="grande">Rines ultralivianos</span><br>
										<span class="pequeño">en <b>aluminio y cromados</b></span>
									</div>
								</div>
							</div>
							<div class="item">
								<img src="recursos/img/sld-3.jpg" alt="...">
								<div class="carousel-caption">
									<div class="etiqueta">
										<span class="grande">Rines ultralivianos</span><br>
										<span class="pequeño">en <b>aluminio y cromados</b></span>
									</div>
								</div>
							</div>
						</div>
						<!-- Controls 
						<a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
							<div class="flecha">
								<span class="fa fa-angle-left fa-3x"></span>
							</div>
						</a>
						<a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
							<div class="flecha">
								<span class="fa fa-angle-right fa-3x"></span>
							</div>
						</a>-->
					</div>
				</div>
			</section>

			<section id="promociones-galeria">
				<div class="container">
					<div class="row">
						<div class="col-sm-8 promociones st-seccion">
							<div class="row">
								<div class="col-xs-12">
									
								</div>
								<div class="col-sm-6">
									<h1 class="st-titulo"><small>Nuestra</small><br>Promoción del mes</h1>
									<p class="">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p>
								</div>
								<div class="col-sm-6">
									<br>
									<img src="recursos/img/img-promociones.png" alt="" class="img-responsive">
								</div>
							</div>
						</div>
						<div class="col-sm-4 galeria st-seccion">
							MUndo
						</div>
					</div>
				</div>
			</section>
		</div>
<!-- Pie de página -->
<?php

$opciones = array(
	'js' => array(
		'recursos/js/index.js'
	)
);

$pie = new html\Pie($opciones);

?>
