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
                        <div ng-if="shoppingcart == undefined" class="alert alert-info bg-color4">
			            	<i>Sin productos</i>
			            </div>
            			<div ng-if="shoppingcart != undefined" class="table-responsive">
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
			                        <tr ng-repeat="(key, product) in shoppingcart.products">
			                            <td>
			                                <img src="recursos/img/muestra-item-llanta.jpg" alt="imagen de producto">
			                            </td>
			                            <td ng-bind="product.name"></td>
			                            <td class="text-right" ng-bind="product.price | currency : '$' : 0"></td>
			                            <td>
			                            	<select name="quantity" ng-model="product.cant" id="shop-cant" ng-change="recalculateTotals(key, 'newValue', product.cant)" class="form-control">
			                            		<option ng-value="1">1</option>
			                            		<option ng-value="2">2</option>
			                            		<option ng-value="3">3</option>
			                            		<option ng-value="4">4</option>
			                            		<option ng-value="5">5</option>
			                            		<option ng-value="6">6</option>
			                            		<option ng-value="7">7</option>
			                            		<option ng-value="8">8</option>
			                            	</select>
			                            </td>
			                            <td class="text-right" ng-bind="(product.price * product.cant) | currency : '$' : 0"></td>
			                        </tr>
			                        <tr class="text-right">
			                            <td colspan="4">
			                                <b class="txt-24 c-color3">Total:</b>
			                            </td>
			                            <td>
			                                <b class="c-color4 txt-24" ng-bind="shoppingcart.total | currency : '$' : 0"></b>
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
                                <button ng-click="close()" ng-disabled="shoppingcart == undefined" class="btn bg-color3 c-blanco text-uppercase">Pagar</button>
	            			</div>
	            		</div>
	            		<hr class="visible-xs">
            		</div>
                    <?php if( !(isset($_SESSION['tym_user_type_id']) && ( $_SESSION['tym_user_type_id'] == '1' )) ): ?>
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
                    <?php endif;?>
            	</div>
            </div>
    	</div>
    </div>
</div>
