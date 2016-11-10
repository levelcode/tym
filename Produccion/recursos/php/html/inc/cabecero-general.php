<header id="cabecero" ng-controller="searchCtrl">
	<a href="/" class="logo" data-toggle="tooltip" data-placement="bottom" title="Inicio">

	</a>
	<?php require_once(_INC.'menu.php') ?>

	<div id="alternador-menu-accesorios" data-toggle="tooltip" data-placement="bottom" title="Mostra u ocultar el menú de accesorios">
	</div>
	<?php require_once(_INC.'menu-accesorios.php') ?>
	<div id="video_aux" class="txt-12 text-center">
		<button data-modal="test" class="hidden-xs btn btn-lg bg-color2 c-blanco text-uppercase">¿Cómo comprar?</button>
	</div>
	<div id="usuario" data-toogle="Usuarios registardos" class="txt-12 text-center">
		<?php if( !isset($_SESSION['id']) ): ?>
			<div class="ingreso" data-modal="ingreso-registro">
				<img src="/recursos/img/icono-usuario.png" alt="usuario">
				<br>
				Ingreso&nbsp;·&nbsp;Registro
				<br>
			</div>
		<?php endif;?>
		<?php if( isset($_SESSION['id']) &&  $_SESSION['tym_user_type_id'] ): ?>
			<div class="registrado text-right">
				<i class="c-color3">Bienvenido</i>&nbsp;<strong class="text-uppercase"><?= $_SESSION['user_name']?></strong><br>
				<button class="btn c-blanco bg-color3 txt-12" data-modal="mi-perfil">Ver Perfil</button>
			</div>
		<?php endif;?>
	</div>

	<button id="btn-carro-compras" class="btn c-blanco" data-modal="carrito-compras" ng-controller="ShoppingCartAxuCtrl"><i class="fa fa-shopping-cart"></i>&nbsp;&nbsp;Ver carrito <span class="badge" ng-bind="numOfProducts"></span></button>
</header>
