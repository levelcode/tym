<div class="panel panel-default">
	<div class="panel-heading">
		<span><i class="fa fa-edit"></i> &nbsp;Editar Contacto</span>
	</div>
	<div class="panel-body">
		<form id="formEditarContacto" name="formEditarContacto">
    		<input type="hidden" id="id_cliente" name="id_cliente">
	    	<br>
			<div class="row">
				<div class="col-sm-6 col-lg-6">
					<div class="form-group">
						<label for="nombre_contacto">Nombre</label>
						<input type="hidden" id="id_contacto" name="id_contacto">
						<input type="text" name="nombre_contacto" id="nombre_contacto" class="form-control">
					</div>
				</div>
				<div class="col-sm-6 col-lg-6">
					<div class="form-group">
						<label for="cargo_contacto">Cargo</label>
						<input type="text" name="cargo_contacto" id="cargo_contacto" class="form-control">
					</div>
				</div>
				<div class="col-sm-6 col-lg-6">
					<div class="form-group">
						<label for="correo_contacto">Correo Electrónico</label>
						<input type="email" name="correo_contacto" id="correo_contacto" class="form-control">
					</div>
				</div>
				<div class="col-sm-6 col-lg-6">
					<div class="form-group">
						<label for="telefono_contacto">Teléfono</label>
						<input type="tel" name="telefono_contacto" id="telefono_contacto" class="form-control">
					</div>
				</div>
			</div>
			<hr>
			<div class="row">
				<div class="col-xs-12 bloque text-right">
					<button class="btn btn-success" type="submit"><i class="fa fa-save"></i> &nbsp;Guardar</button>
				</div>
			</div>
		</form>
	</div>
</div>