<!-- Cabecero -->
<?php
require_once('recursos/php/config.php');

$opciones = array(
	'responsivo' => true,
	'descripcion' => 'La descripción aquí',
	'autor' => 'prograCOL - http://progracol.com',
	'titulo' => 'Empresas Aliadas - '._TITULO,
	'css' => array(
		'recursos/css/empresas-aliadas.css'
	),
	'js' => array()
);

$cabecero = new html\Cabecero($opciones);


?>

<!-- contenido -->
		<div id="contenido">
			<div id="titulo">
				<h1 class="text-uppercase">Empresas Aliadas</h1>
			</div>

			<section id="slider">
				<div class="container">
					<div class="row">
						<div class="col-xs-12">
							<div id="rotabanner" class="carousel slide" data-ride="carousel">
							<!-- Wrapper for slides --> 
							<div class="carousel-inner" role="listbox">
								<div class="item active sld-1">
									<div class="container-fluid">
										<div class="row">
											<div class="col-sm-8 col-sm-offset-2 sld">
												<div class="row">
													<div class="col-sm-5">
														<img src="recursos/img/logo-tym-navidad.png" alt="" class="img-responsive">
													</div>
													<div class="col-sm-7">
														<h2 class="text-uppercase c-color3">Navidad TYM</h2>
														<h3>Conoce aquí todos los productos!</h3>

														<p>TYM posee un gran portafolio de productos navideños tales como: Arboles, Muñecos, Guirnaldas, Coronas y Bolas. Con un amplio inventario y los mejores precios TYM logra difundir la alegría de la navidad en los hogares Colombianos.</p>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="item sld-2">
									<div class="container-fluid">
										<div class="row">
											<div class="col-sm-8 col-sm-offset-2 sld">
												<div class="row">
													<div class="col-sm-5">
														<img src="recursos/img/logo-easy.png" alt="" class="img-responsive">
													</div>
													<div class="col-sm-7">
														<h2 class="text-uppercase c-color3">Easy imports</h2>
														<h3><a href="http://www.easyimports.com.co">www.easyimports.com.co</a></h3>

														<p>Es una empresa dedicada a la importación distribución y venta de cámaras de seguridad en todo el territorio colombiano, nuestro compromiso es de atender con esmero y buen servicio, un mercado masivo de productos para seguridad. </p>
 
														<p>De esta manera, poder suministrar nuestra amplia gama de productos, para cubrir así todas las necesidades en la relación sistemas de seguridad.</p>
													</div>
												</div>
											</div>
										</div>
									</div>	
								</div>
								<div class="item sld-3">
									<div class="container-fluid">
										<div class="row">
											<div class="col-sm-8 col-sm-offset-2 sld">
												<div class="row">
													<div class="col-sm-5">
														<img src="recursos/img/logo-femm.png" alt="" class="img-responsive">
													</div>
													<div class="col-sm-7">
														<h2 class="text-uppercase c-color3">FEMM S.A.S</h2>
														<h3><a href="http://www.femm.com.co">www.femm.com.co</a></h3>

														<p>Diseña, fabrica e importa equipos para movimiento como son:</p>
 
														<i>Ascensores de Pasajeros,</i> hospitalarios, carga, montacoches, de obra, montaplatos, para discapacitados.<br>
														<i>Sillas Salva Escaleras</i> para tramos curvos o rectos (Discapacitados)<br>
														<i>Plataformas Salva Escaleras</i> para tramos curvos o rectos (Discapacitados)<br>
														<i>Plataformas y Rampas vehiculares</i> para camionetas, busetas y buses (Discapacitados)<br>
														<i>Monorrieles</i> para discapacitados para viviendas y hospitales<br>
														<i>Sillas de tracción eléctrica</i> para subir escaleras para superar barreras arquitectónicas<br>
														<i>Rampa Móvil</i> (Acceso a Sótano y Semi - Sótano)<br>
														<i>Servicio de mantenimiento</i> preventivo y correctivo para equipos fabricados por nosotros, así como de otras empresas y marcas.
													</div>
												</div>
											</div>
										</div>	
									</div>
								</div>
								<div class="item sld-4">
									<div class="container-fluid">
										<div class="row">
											<div class="col-sm-8 col-sm-offset-2 sld">
												<div class="row">
													<div class="col-sm-5">
														<img src="recursos/img/logo-puente-gruas.png" alt="" class="img-responsive">
													</div>
													<div class="col-sm-7">
														<h2 class="text-uppercase c-color3">Puente Gruas</h2>
														<h3><a href="http://www.puentegruasfemm.com">www.puentegruasfemm.com</a></h3>

														<p>Nuestros años de experiencia y el reconocimiento de nuestros clientes por la calidad de nuestros productos, han ubicado a FEMM S.A.S. entre los principales fabricantes de equipos para movimiento vertical de materiales y pasajeros en Colombia. Las crecientes exigencias del mercado, nos han llevado a adquirir un carácter de continua mejora y excelencia. No dude en contactarnos, estamos para servirle!</p>
													</div>
												</div>
											</div>
										</div>	
									</div>		
								</div>
								<div class="item sld-5">
									<div class="container-fluid">
										<div class="row">
											<div class="col-sm-8 col-sm-offset-2 sld">
												<div class="row">
													<div class="col-sm-5">
														<img src="recursos/img/logo-smart-motion.png" alt="" class="img-responsive">
													</div>
													<div class="col-sm-7">
														<h2 class="text-uppercase c-color3">Smart Motion SAS</h2>
														<h3><a href="http://www.smartmotion.com.co">www.smartmotion.com.co</a></h3>

														<p>Es nuestro compromiso entregar productos y servicios de óptima calidad, ya que para nuestros clientes es de vital importancia mantener altos estándares de calidad, por lo cual estamos en constante innovación y a la vanguardia en los avances tecnológicos.</p>
													</div>
												</div>
											</div>
										</div>	
									</div>
								</div>
							</div>
							<!-- Controls -->
							<a class="left carousel-control" href="#rotabanner" role="button" data-slide="prev">
								<div class="flecha">
									<span class="fa fa-angle-left fa-3x"></span>
								</div>
							</a>
							<a class="right carousel-control" href="#rotabanner" role="button" data-slide="next">
								<div class="flecha">
									<span class="fa fa-angle-right fa-3x"></span>
								</div>
							</a>

							<!-- Indicators -->
							<ol class="carousel-indicators">
								<li data-target="#rotabanner" data-slide-to="0" class="active"></li>
								<li data-target="#rotabanner" data-slide-to="1"></li>
								<li data-target="#rotabanner" data-slide-to="2"></li>
								<li data-target="#rotabanner" data-slide-to="3"></li>
								<li data-target="#rotabanner" data-slide-to="4"></li>
							</ol>
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
		'recursos/js/empresas-aliadas.js'
	)
);

$pie = new html\Pie($opciones);

?>
