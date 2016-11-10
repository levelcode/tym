<div class="panel panel-default">
	<div class="panel-heading">
		<span><i class="fa fa-edit"></i> &nbsp;Editar Cliente</span>
	</div>
	<div class="panel-body">
		<form id="form_cliente_editar"  name="form_cliente_editar">
    		<input type="hidden" id="id_cliente"  name="id_cliente">
    		<br>
			<div class="row">
				<div class="col-sm-6 col-lg-4">
					<div class="form-group">
						<label for="compania">Compañia</label>
						<input type="text" name="compania" id="compania"  class="form-control">
					</div>
				</div>
				<div class="col-sm-6 col-lg-4">
					<div class="form-group">
						<label for="nit">Nit</label>
						<input type="text" name="nit" id="nit"  class="form-control">
					</div>
				</div>
				<div class="col-sm-6 col-lg-4">
					<div class="form-group">
						<label for="tipo">Tipo</label>
						<select name="tipo" id="tipo"  class="form-control">
							<option>-- selecciona una opción --</option>
							<option value="DE">DE</option>
							<option value="NI">NI</option>
							<option value="CC">CC</option>
						</select>
					</div>
				</div>
				<div class="col-sm-16 col-lg-4">
					<div class="form-group">
						<label for="direccion">Dirección</label>
						<input type="text" name="direccion" id="direccion"  class="form-control">
					</div>
				</div>
				<div class="col-sm-6 col-lg-4">
					<div class="form-group">
						<label for="correo_cliente">Correo Electrónico</label>
						<input type="email" name="correo_cliente" id="correo_cliente"  class="form-control">
					</div>
				</div>
				<div class="col-sm-6 col-lg-4">
					<div class="form-group">
						<label for="pais">País</label>
						<input type="text" name="pais" id="pais"  class="form-control">
					</div>
				</div>
				<div class="col-sm-6 col-lg-4">
					<div class="form-group">
						<label for="ciudad_cliente">Ciudad</label>
						<input type="text" name="ciudad_cliente" id="ciudad_cliente"  class="form-control">
					</div>
				</div>
				<div class="col-sm-6 col-lg-4">
					<div class="form-group">
						<label for="pbx">Pbx</label>
						<input type="text" name="pbx" id="pbx"  class="form-control">
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
