<script type="text/ng-template" id="send-email.html">
	<div class="panel panel-default">
		<div class="panel-heading">
			<span><i class="fa fa-envelope"></i> &nbsp;Enviar Correo</span>
		</div>
		<div class="panel-body">
			<form id="formEnviarCorreo" name="formEnviarCorreo" >
		    	<br>
				<div class="row">
					<div class="col-sm-12 col-lg-12">
						<div class="form-group">
							<label for="correo">Correo</label>
							<input type="hidden" id="idEnviarCorreo" name="idEnviarCorreo">
							<input type="email"  ng-model="userData.email" name="correo" id="correo" class="form-control" >
						</div>
					</div>
					<div class="col-sm-12 col-lg-12">
						<div class="form-group">
							<label for="observaciones">Observaciones</label>
							<textarea name="observaciones" ng-model="userData.notes" id="observaciones" class="form-control"></textarea>
						</div>
					</div>
				</div>
				<hr>
				<div class="row">
					<div class="col-xs-12 bloque text-right">
						<a class="btn btn-danger" ng-click="cancel()"><i class="fa fa-remove"></i> &nbsp;Cancelar</a>
						<button class="btn btn-success" ng-click="send( userData )" ng-disabled="formEnviarCorreo.$invalid"><i class="fa fa-save"></i> &nbsp;Enviar</button>
					</div>
				</div>
			</form>
		</div>
	</div>
</script>