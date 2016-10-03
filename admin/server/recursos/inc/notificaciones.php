	<div class="contenido text-center">
		<br>
		<div class="alert alert-info" ng-if="loadingNotifications || notifications.empty">
			<span ng-if="loadingNotifications"><strong>Cargando &nbsp;<i class="fa fa-circle-o-notch fa-spin"></i></strong></span>
			<strong ng-if="notifications.empty">No existen nuevas solicitudes de recolección </strong>
		</div>
		<ul class="notificaciones" ng-if="!notifications.empty">
			<li class="notificacion" ng-repeat="request in notifications.data">
			<!-- 	<div class="icono">
					<i class="fa fa-exclamation-triangle"></i>
				</div> -->
				<div class="texto">
					<h4 ng-if="request.collect_status_id == 2" ng-bind="'Residuo asignado'"></h4>
					<h4 ng-if="request.collect_status_id == 3" ng-bind="'Residuo recolectado'"></h4>
					<h4 ng-if="request.collect_status_id == 4" ng-bind="'Residuo Confirmado'"></h4>
					<p ng-bind="'Cliente: ' + request.client_name"></p>
					<p ng-bind="'Dirección :' + request.address_line1"></p>
					<p ng-bind="'Residuo: ' + request.quantity + ' ' + request.unit + ' de ' + request.type"></p>
					<p ng-bind="'Solicitado el : ' + request.request_date"></p>
				</div>
			</li>
		</ul>
	</div>
