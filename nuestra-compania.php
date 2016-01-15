<!-- Cabecero -->
<?php
require_once('recursos/php/config.php');

$opciones = array(
	'responsivo' => true,
	'descripcion' => 'La descripción aquí',
	'autor' => 'prograCOL - http://progracol.com',
	'titulo' => 'Empresas Aliadas - '._TITULO,
	'css' => array(
		'recursos/css/nuestra-compania.css'
	),
	'js' => array(
		'recursos/js/angular.min.js',
		'recursos/js/ui-bootstrap-tpls-0.13.4.min.js',
		'recursos/js/angular-cookies.min.js',
		'recursos/js/ng-file-upload/ng-file-upload.min.js',
		'recursos/js/angular-sanitize.min.js'
	)
);

$cabecero = new html\Cabecero($opciones);


?>

<!-- contenido -->
		<div id="contenido">
			<?php require_once(_INC.'slider-intro.php'); ?>


			<section id="compania" class="st-seccion bg-color1">
				<div class="container">
					<div class="row">
						<div class="col-sm-6">
							<div class="st-titulo">
								<small>Nuestra</small>
								<h1>Compañía</h1>
							</div>
							<i class="st-separador"></i>
							<br>
							<img src="recursos/img/imagen-nuestra-compania-tym.png" alt="" class="img-responsive">
							<hr class="visible-xs">
							<br>
						</div>
						<div class="col-sm-6 txt-13">
							<p><strong>Rines TYM es una empresa importadora y comercializadora de Auto-partes</strong> en Colombia. Productos tales como rines en aluminio y accesorios de lujo; Entre nuestras marcas que representamos están Dlaa, Winbo, Powerful, Pdw, Pentair, Toptrue, Yueling, Powcan, Shlk, Libao.</p>

							<p><strong>TYM</strong> tines presencia a nivel nacional, por más de 10 años y es reconocida como una marca líder en el mercado por su alta calidad y diseño en sus productos.</p>

							<p>Contamos con todos los accesorios de lujo para automóvil y camionetas 4x4; además una gran capacidad de inventario de rines y accesorios en todas las referencias modelos y medidas, nos permite satisfacer las necesidades de nuestros clientes de forma inmediata a los mejores precios del mercado. </p>

							<p>Ofrecemos un excelente servicio de distribución y otros servicios complementarios, aplicando al contexto colombiano los modelos más eficaces de gestión empresarial y contando con un equipo humano idóneo y comprometido.</p>

							<p>Esto nos permite dar a nuestros clientes la mejor calidad a un precio competitivo, mantener una posición de liderazgo en Colombia y contribuir al desarrollo empresarial del mismo.</p>

							<p><strong>TYM</strong> esta a la espera de nuevos clientes y distribuidores interesados en formar parte de esta gran familia.</p>
						</div>
					</div>
				</div>
			</section>
		</div>
<!-- Pie de página -->
<?php

$opciones = array(
	'js' => array(
		'recursos/js/nuestra-compania.js',
		'server/js/angularApp/angularApp.js',
		'server/js/angularApp/controllers/productListHeaderCtrl.js',
		'server/js/angularApp/controllers/productListCtrl.js',
		'server/js/angularApp/controllers/productDetailCtrl.js',
		'server/js/angularApp/controllers/monthPromotionCtrl.js',
		'server/js/angularApp/controllers/shoppingCartAxuCtrl.js',
		'server/js/angularApp/controllers/menuProductCtrl.js',
		'server/js/angularApp/controllers/modals/LoginSignUpCtrl.js',
		'server/js/angularApp/controllers/modals/profileCtrl.js',
		'server/js/angularApp/controllers/modals/shoppingCartCtrl.js',
		'server/js/angularApp/services/constantService.js',
		'server/js/angularApp/services/utilService.js'
	)
);

$pie = new html\Pie($opciones);

?>
