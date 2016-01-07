<header id="cabecero">
	<a href="./" class="logo" data-toggle="tooltip" data-placement="bottom" title="Inicio">
		<img src="recursos/img/logo.png" class="img-responsive" alt="">
	</a>
	<?php require_once(_INC.'menu.php') ?>

	<div id="alternador-menu-accesorios" data-toggle="tooltip" data-placement="bottom" title="Mostra u ocultar el menú de accesorios">
	</div>
	<?php require_once(_INC.'menu-accesorios.php') ?>

	<div id="usuario" data-toogle="Usuarios registardos" class="txt-12 text-center">
		<!-- <div class="ingreso">
			<img src="recursos/img/icono-usuario.png" alt="usuario">
			<br>
			Ingreso&nbsp;·&nbsp;Registro
		</div> -->

		<div class="registrado text-right">
			<i class="c-color3">Bienvenido</i>&nbsp;<strong class="text-uppercase">Andrés Beltrán</strong><br>
			<button class="btn c-blanco bg-color3 txt-12" data-modal="mi-perfil">Ver Perfil</button>
		</div>
	</div>
</header>