<script type="text/ng-template" id="edit-profile.html">
	<div class="panel panel-default">
		<div class="panel-heading">
			<i class="fa fa-user-plus"></i> &nbsp;Editar Perfil
		</div>
		<form id="form-editar" name="formEditar" method="POST">
			<div class="panel-body">
				
				<!-- imágenes -->
				<div class="col-sm-3 text-center">
					<img src="recursos/img/no-user.png" alt="" class="img-thumbnail" id="preview-foto">
					<div class="bloque">
						<button type="button" class="btn btn-primary" id="btn-cambiar-foto">Cambiar Foto</button>
					</div>
					<hr>
				</div>

				<!-- campos -->
				<div class="col-sm-9">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
								<label for="editar_nombre">Nombres</label>
								<input type="text" name="name" id="editar_nombre" ng-model="userData.name" class="form-control" data-regexp="nombre" disabled>
							</div>
						</div>
						<div class="col-sm-6" ng-if="userData.user_type_id != 1">
							<div class="form-group">
								<label for="editar_apellido">Apellidos</label>
								<input type="text" name="last_name" id="editar_apellido"  class="form-control" data-regexp="nombre">
							</div>
						</div>
						<div class="col-sm-8">
							<div class="form-group">
								<label for="editar_email">Correo Electrónico (Remisión)</label>
								<input type="email" name="email" id="editar_email" ng-model="userData.email" class="form-control" required>
							</div>
						</div>

						<div class="col-sm-4">
							<div class="form-group">
								<label for="editar_iniciales">Perfil</label>
								<input type="text" name="profile" id="editar_profile" ng-model="userData.profile" class="form-control" disabled>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label for="pass">Contraseña{{formEditar.$dirty}}</label>
								<input type="password" name="pass" id="pass" ng-model="userData.pass" class="form-control" ng-minLength="6" ng-required="formEditar.pass2.$viewValue != '' && formEditar.pass2.$dirty">
								<span ng-if="formEditar.pass.$error.minlength" class="help-block">Debe contener mínimo 6 digitos</span>
								<span ng-if="formEditar.pass.$error.required && formEditar.pass2.$dirty" class="help-block">Completa este campo</span>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
								<label for="pass2">Repite Contraseña </label>
								<input type="password" name="pass2" id="pass2" ng-model="userData.pass2" ng-change="validatePassword( userData.pass, userData.pass2 )" class="form-control" ng-minLength="6" ng-required="formEditar.pass.$viewValue != '' && formEditar.pass.$dirty">
								<span ng-if="formEditar.pass2.$error.minlength" class="help-block">Debe contener mínimo 6 digitos</span>
								<span ng-if="formEditar.pass2.$error.required && formEditar.pass.$dirty" class="help-block">Completa este campo</span>
								<span ng-if="formEditar.pass2.$error.passNoEqual" class="help-block">Las contraseñas no coinciden</span>
							</div>

						</div>
					</div>
				</div>							
			</div>
			<div class="panel-footer">
				<div class="row">
					<div class="col-xs-12 bloque text-right">
						<button class="btn btn-warning" type="button" ng-click="cancel()">Cancelar</button>
						<button class="btn btn-success" data-id="<?= $_SESSION["id"]?>" ng-disabled="(formEditar.$invalid && formEditar.$dirty) || sendingRequest" ng-click="save()" type="submit"><i ng-hide="sendingRequest" class="fa fa-save"></i><i ng-if="sendingRequest" class="fa fa-circle-o-notch fa-spin"></i> &nbsp;Guardar</button>
					</div>
				</div>
			</div>
		</form>
	</div>
</script>