<!-- modal -->
<div id="modal-carrito-compras" class="st-modal modal-tym" ng-controller="shoppingCartCtrl">
    <div class="contenido">
		<span class="cerrar"><i class="fa fa-remove"></i></span>
		<div class="cont">
            <div class="titulo">
                <h1>Carrito de compras</h1>
            </div>
            <div class="container">
            	<div class="row">
            		<div class="col-sm-7">
            			<div class="table-responsive">
			                <table class="tabla text-center">
			                    <thead>
			                        <tr>
			                            <th>ITEM</th>
			                            <th>NOMBRE</th>
			                            <th>PRECIO</th>
			                            <th>CANTIDAD</th>
			                            <th>SUBTOTAL</th>
			                        </tr>
			                    </thead>
			                    <tbody>
			                        <tr>
			                            <td>
			                                <img src="recursos/img/muestra-item-llanta.jpg" alt="imagen de producto">
			                            </td>
			                            <td>7618</td>
			                            <td class="text-right">$180.000</td>
			                            <td>
			                            	<select name="" id="" class="form-control">
			                            		<option value="1">1</option>
			                            		<option value="2">2</option>
			                            		<option value="3">3</option>
			                            		<option value="4">4</option>
			                            		<option value="5">5</option>
			                            		<option value="6">6</option>
			                            		<option value="7">7</option>
			                            		<option value="8">8</option>
			                            	</select>
			                            </td>
			                            <td class="text-right">$720.000</td>
			                        </tr>
			                        <tr>
			                            <td>
			                                <img src="recursos/img/muestra-item-silla.jpg" alt="imagen de producto">
			                            </td>
			                            <td>MS-113</td>
			                            <td class="text-right">$400.000</td>
			                            <td>
			                            	<select name="" id="" class="form-control">
			                            		<option value="1">1</option>
			                            		<option value="2">2</option>
			                            		<option value="3">3</option>
			                            		<option value="4">4</option>
			                            		<option value="5">5</option>
			                            		<option value="6">6</option>
			                            		<option value="7">7</option>
			                            		<option value="8">8</option>
			                            	</select>
			                            </td>
			                            <td class="text-right">$800.000</td>
			                        </tr>
			                        <tr class="text-right">
			                            <td colspan="4">
			                                <b class="txt-24 c-color3">Total:</b>
			                            </td>
			                            <td>
			                                <b class="c-color4 txt-24">$1'920.000</b>
			                            </td>
			                        </tr>
			                    </tbody>
			                </table>
			            </div>
			            <hr>

			            <div class="alert alert-info bg-color4">
			            	<i>Despachos sin costo a ciudades principales mayor información sobre envíos especiales via e-mail o contacte nuestro asesor en línea.</i>
			            </div>

			            <div class="row">
	            			<div class="col-xs-12 text-right">
	            				<button ng-click="close()" class="btn bg-color3 c-blanco text-uppercase">Volver a la tienda</button>
	            			</div>
	            		</div>
	            		<hr class="visible-xs">
            		</div>
            		<div class="col-sm-5">
            			<div class="registro-compra bg-color3 text-left">
            				<h3 class="text-uppercase">Registra tu compra</h3>

            				<form action="">
            					<div class="form-group">
            						<label for="">Nombre:</label>
            						<input type="text" name="" id="" class="form-control">
            					</div>
            					<div class="form-group">
            						<label for="">E-Mail:</label>
            						<input type="text" name="" id="" class="form-control">
            					</div>
            					<div class="form-group">
            						<label for="">Celular:</label>
            						<input type="text" name="" id="" class="form-control">
            					</div>
            					<div class="form-group">
            						<label for="">Teléfono fijo:</label>
            						<input type="text" name="" id="" class="form-control">
            					</div>
            				</form>
            			</div>
						<br>
            			<div class="row">
	            			<div class="col-xs-12 text-right">
	            				<button class="btn bg-color2 c-blanco text-uppercase">Continuar</button>
	            			</div>
	            		</div>
            		</div>
            	</div>
            </div>
    	</div>
    </div>
</div>
