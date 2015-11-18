	<div ng-controller="notificationsCtrl">	
		<!-- Cabecero -->
		<header>
			<div class="logo">
				<a href="./admin" title="Dirigirse al inicio" data-toggle="tooltip" data-placement="bottom">
					<img src="recursos/img/logo.png" alt="logotipo">
				</a>
			</div>			
			<!-- alternador menu -->
			<div class="alternador">
				<i class="fa fa-reorder"></i>
			</div>
			<!-- <a href="#" class="lupa">
				<i class="fa fa-search"></i>
			</a> -->
			<a href="#" class="actualizar">
				<i class="fa fa-refresh"></i>
			</a>
			<!-- <a href="#" class="notificaciones">
				<i class="fa fa-bell"></i>
				<div id="notification-alert" ng-if="!notifications.empty">
					<span ng-bind="notifications.data.length"></span>
				</div>
			</a> -->
			<input type="hidden" id="id_cliente" name="id_cliente" ng-model="userId" ng-init="userId= <?= $_SESSION['id']?>">
			<input type="hidden" id="user_type_id" name="user_type_id" ng-model="userTypeId" ng-init="userTypeId=<?= $_SESSION['user_type_id']?>">
		</header>
		<!-- <div id="cargando-datos">
		    <img src="recursos/img/preloader-s.gif" alt=""> <span>&nbsp;Cargando datos</span>
		</div> -->
		<?php require(_INC_ADMIN.'menu-general.php'); ?>
		<?php// require(_INC_ADMIN.'busqueda-general.php'); ?>
		<div id="notificaciones">
			<?php// require(_INC_ADMIN.'notificaciones.php'); ?>
		</div>
		<?php //require(_INC_ADMIN.'usuario.php'); ?>
	</div>